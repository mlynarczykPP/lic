<?php
/**
 * Sales controller.
 */

namespace App\Controller;

use App\Entity\Sales;
use App\Form\Type\SalesType;
use App\Service\SalesService as SalesServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class SalesController.
 *
 * @Route("/sales")
 */
class SalesController extends AbstractController
{
    /**
     * Sales service.
     */
    private SalesServiceInterface $salesService;

    /**
     * Translator.
     *
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param SalesServiceInterface $salesService Sale service
     * @param TranslatorInterface $translator Translator
     */
    public function __construct(SalesServiceInterface $salesService, TranslatorInterface $translator)
    {
        $this->salesService = $salesService;
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
     *     name="sales_index",
     * )
     */
    public function index(Request $request): Response
    {
        $filters = $this->getFilters($request);
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if ($hasAccess == "ROLE_ADMIN") {
            $pagination = $this->salesService->getPaginatedListAdm(
                $request->query->getInt('page', 1),
                $filters
                );
        }
        else {
            $pagination = $this->salesService->getPaginatedList(
                $request->query->getInt('page', 1),
                $this->getUser(),
                $filters
            );
        }

        return $this->render('sales/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Sales $sales Sales entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="sales_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Sales $sales): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if ($hasAccess == "ROLE_ADMIN") {
            return $this->render(
                'sales/show.html.twig',
                ['sales' => $sales]
            );
        }

        if ($sales->getAuthor() !== $this->getUser()) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.record_not_found')
            );

            return $this->redirectToRoute('sales_index');
        }

        return $this->render(
            'sales/show.html.twig',
            ['sales' => $sales]
        );
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
     *     name="sales_create",
     * )
     */
    public function create(Request $request): Response
    {
        $user = $this->getUser();
        $sales = new Sales();
        $sales->setAuthor($user);
        $form = $this->createForm(SalesType::class, $sales);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->salesService->save($sales);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('sales_index');
        }

        return $this->render(
            'sales/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param Sales $sales Sales entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="sales_edit",
     * )
     */
    public function edit(Request $request, Sales $sales): Response
    {
        $form = $this->createForm(SalesType::class, $sales, [
            'method' => 'PUT',
            'action' => $this->generateUrl('sales_edit', ['id' => $sales->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->salesService->save($sales);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('sales_index');
        }

        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if ($hasAccess == "ROLE_ADMIN") {
            return $this->render(
                'sales/edit.html.twig',
                [
                    'form' => $form->createView(),
                    'sales' => $sales,
                ]
            );
        }

        return $this->redirectToRoute('sales_index');
    }


    /**
     * Delete action.
     *
     * @param Request  $request  HTTP request
     * @param Sales $sales Sales entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="sales_delete",
     * )
     */
    public function delete(Request $request, Sales $sales): Response
    {
        $form = $this->createForm(FormType::class, $sales, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('sales_delete', ['id' => $sales->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->salesService->delete($sales);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('sales_index');
        }

        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if ($hasAccess == "ROLE_ADMIN"){
            return $this->render(
                'sales/delete.html.twig',
                [
                    'form' => $form->createView(),
                    'sales' => $sales,
                ]
            );
        }

        return $this->redirectToRoute('sales_index');
    }

    /**
     * Get filters from request.
     *
     * @param Request $request HTTP request
     *
     * @return array<string, int> Array of filters
     *
     * @psalm-return array{category_id: int, tag_id: int, status_id: int}
     */
    private function getFilters(Request $request): array
    {
        $filters = [];
        $filters['adds_id'] = $request->query->getInt('filters_adds_id');

        return $filters;
    }
}
