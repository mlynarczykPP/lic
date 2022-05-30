<?php
/**
 * Adds controller.
 */

namespace App\Controller;

use App\Entity\Add;
use App\Form\Type\AddsType;
use App\Service\AddsService as AddsServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class AddController.
 *
 * @Route("/adds")
 */
class AddsController extends AbstractController
{
    /**
     * Adds service.
     */
    private AddsServiceInterface $addsService;

    /**
     * Translator.
     *
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param AddsServiceInterface $addsService Add service
     * @param TranslatorInterface $translator Translator
     */
    public function __construct(AddsServiceInterface $addsService, TranslatorInterface $translator)
    {
        $this->addsService = $addsService;
        $this->translator = $translator;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP Request
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="adds_index",
     * )
     */
    public function index(Request $request): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if ($hasAccess == "ROLE_ADMIN") {
            $pagination = $this->addsService->getPaginatedList(
                $request->query->getInt('page', 1)
            );

            return $this->render('adds/index.html.twig', ['pagination' => $pagination]);
        }

        $this->addFlash(
            'warning',
            ('Brak dostępu!')
        );

        return $this->redirectToRoute('sales_index');
    }

    /**
     * Show action.
     *
     * @param Add $add Add entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="adds_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Add $add): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if ($hasAccess == "ROLE_ADMIN") {
            return $this->render(
                'adds/show.html.twig',
                ['adds' => $add]
            );
        }

        $this->addFlash(
            'warning',
            ('Brak dostępu!')
        );

        return $this->redirectToRoute('sales_index');
    }

    /**
     * Create action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="adds_create",
     * )
     */
    public function create(Request $request): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if ($hasAccess == "ROLE_ADMIN") {
            $add = new Add();
            $form = $this->createForm(AddsType::class, $add);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->addsService->save($add);

                $this->addFlash(
                    'success',
                    $this->translator->trans('message.created_successfully')
                );

                return $this->redirectToRoute('adds_index');
            }

            return $this->render(
                'adds/create.html.twig',
                ['form' => $form->createView()]
            );
        }

        $this->addFlash(
            'warning',
            ('Brak dostępu!')
        );

        return $this->redirectToRoute('sales_index');
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param Add $add Add entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="adds_edit",
     * )
     */
    public function edit(Request $request, Add $add): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if ($hasAccess == "ROLE_ADMIN") {
            $form = $this->createForm(AddsType::class, $add, [
                'method' => 'PUT',
                'action' => $this->generateUrl('adds_edit', ['id' => $add->getId()]),
            ]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->addsService->save($add);

                $this->addFlash(
                    'success',
                    $this->translator->trans('message.edited_successfully')
                );

                return $this->redirectToRoute('adds_index');
            }

            return $this->render(
                'adds/edit.html.twig',
                [
                    'form' => $form->createView(),
                    'add' => $add,
                ]
            );
        }

        $this->addFlash(
            'warning',
            ('Brak dostępu!')
        );

        return $this->redirectToRoute('sales_index');
    }

    /**
     * Delete action.
     *
     * @param Request  $request  HTTP request
     * @param Add $add Add entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="adds_delete",
     * )
     */
    public function delete(Request $request, Add $add): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if ($hasAccess == "ROLE_ADMIN") {
            $form = $this->createForm(FormType::class, $add, [
                'method' => 'DELETE',
                'action' => $this->generateUrl('adds_delete', ['id' => $add->getId()]),
            ]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->addsService->delete($add);

                $this->addFlash(
                    'success',
                    $this->translator->trans('message.deleted_successfully')
                );

                return $this->redirectToRoute('adds_index');
            }

            return $this->render(
                'adds/delete.html.twig',
                [
                    'form' => $form->createView(),
                    'add' => $add,
                ]
            );
        }

        $this->addFlash(
            'warning',
            ('Brak dostępu!')
        );

        return $this->redirectToRoute('sales_index');
    }
}
