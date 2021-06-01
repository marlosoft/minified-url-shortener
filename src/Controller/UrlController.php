<?php

namespace App\Controller;

use App\Entity\Url;
use App\Form\UrlType;
use App\Repository\UrlRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class UrlController
 * @package App\Controller
 */
class UrlController extends AbstractController
{
    /**
     * @Route("/", name="app_url_index")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @param UrlGeneratorInterface $urlGenerator
     * @return Response
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator
    ): Response {
        $form = $this->createForm(UrlType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Url $url */
            $url = $form->getData();
            $shortUrl = $urlGenerator->generate(
                'app_url_expand',
                ['url' => $url->getId()->toBase58()],
                UrlGeneratorInterface::ABSOLUTE_URL
            );

            $entityManager->persist($url);
            $entityManager->flush();

            $this->addFlash('success', $shortUrl);

            return $this->redirectToRoute('app_url_index');
        }

        return $this->render('url/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{url}", name="app_url_expand", requirements={"url"="^([A-Za-z0-9]+)$"})
     * @Entity("url")
     * @param Url|null $url
     * @return Response
     */
    public function expand(?Url $url): Response
    {
        if (empty($url)) {
            throw new NotFoundHttpException();
        }

        return $this->redirect($url->getPath());
    }
}
