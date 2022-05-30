<?php
/**
 * Note controller.
 */

namespace App\Controller;

use App\Entity\Note;
use App\Form\Type\NoteType;
use App\Service\NoteService as NoteServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class NoteController.
 *
 * @Route("/notes")
 */
class NoteController extends AbstractController
{
    /**
     * Note service.
     */
    private NoteServiceInterface $noteService;

    /**
     * Translator.
     *
     * @var TranslatorInterface
     */
    private TranslatorInterface $translator;

    /**
     * Constructor.
     *
     * @param NoteServiceInterface $noteService Note service
     * @param TranslatorInterface $translator Translator
     */
    public function __construct(NoteServiceInterface $noteService, TranslatorInterface $translator)
    {
        $this->noteService = $noteService;
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
     *     name="note_index",
     * )
     */
    public function index(Request $request): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if ($hasAccess == "ROLE_ADMIN") {
            $pagination = $this->noteService->getPaginatedListAdm(
                $request->query->getInt('page', 1)
            );
        }
        else {
            $pagination = $this->noteService->getPaginatedList(
                $request->query->getInt('page', 1),
                $this->getUser()
            );
        }

        return $this->render('note/index.html.twig', ['pagination' => $pagination]);
    }

    /**
     * Show action.
     *
     * @param Note $note Note entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="note_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Note $note): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN');
        if ($hasAccess == "ROLE_ADMIN") {
            return $this->render(
                'note/show.html.twig',
                ['note' => $note]
            );
        }

        if ($note->getAuthor() !== $this->getUser()) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.record_not_found')
            );

            return $this->redirectToRoute('note_index');
        }

        return $this->render(
            'note/show.html.twig',
            ['note' => $note]
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
     *     name="note_create",
     * )
     */
    public function create(Request $request): Response
    {
        $user = $this->getUser();
        $note = new Note();
        $note->setAuthor($user);
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->noteService->save($note);

            $this->addFlash(
                'success',
                $this->translator->trans('message.created_successfully')
            );

            return $this->redirectToRoute('note_index');
        }

        return $this->render(
            'note/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request  $request  HTTP request
     * @param Note $note Note entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="note_edit",
     * )
     */
    public function edit(Request $request, Note $note): Response
    {
        if ($note->getAuthor() !== $this->getUser()) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.record_not_found')
            );

            return $this->redirectToRoute('note_index');
        }

        $form = $this->createForm(NoteType::class, $note, [
            'method' => 'PUT',
            'action' => $this->generateUrl('note_edit', ['id' => $note->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->noteService->save($note);

            $this->addFlash(
                'success',
                $this->translator->trans('message.edited_successfully')
            );

            return $this->redirectToRoute('note_index');
        }

        return $this->render(
            'note/edit.html.twig',
            [
                'form' => $form->createView(),
                'note' => $note,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request  $request  HTTP request
     * @param Note $note Note entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="note_delete",
     * )
     */
    public function delete(Request $request, Note $note): Response
    {
        if ($note->getAuthor() !== $this->getUser()) {
            $this->addFlash(
                'warning',
                $this->translator->trans('message.record_not_found')
            );

            return $this->redirectToRoute('note_index');
        }

        $form = $this->createForm(FormType::class, $note, [
            'method' => 'DELETE',
            'action' => $this->generateUrl('note_delete', ['id' => $note->getId()]),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->noteService->delete($note);

            $this->addFlash(
                'success',
                $this->translator->trans('message.deleted_successfully')
            );

            return $this->redirectToRoute('note_index');
        }

        return $this->render(
            'note/delete.html.twig',
            [
                'form' => $form->createView(),
                'note' => $note,
            ]
        );
    }
}
