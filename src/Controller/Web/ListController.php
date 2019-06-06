<?php
namespace App\Controller\Web;

use App\Repository\UsersRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ListController extends AbstractController
{
    /**
     * @Route("/list-users", name="list_users")
     * @param Request $request
     * @param UsersRepository $usersRepository
     * @param PaginatorInterface $paginator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(
        Request $request,
        UsersRepository $usersRepository,
        PaginatorInterface $paginator
    ) {

        $sort = $request->query->get('order', 'ASC');
        $queryBuilder = $usersRepository->getUsers($sort);

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1)
        );

        return $this->render('users_list.html.twig', [
            'pagination' => $pagination,
            'sort'       => $sort
        ]);
    }

    /**
     * @Route("/filter", methods={"POST"})
     * @param Request $request
     * @param UsersRepository $usersRepository
     * @param SerializerInterface $serializer
     * @return Response
     */
    public function filter(
        Request $request,
        UsersRepository $usersRepository,
        SerializerInterface $serializer
    ) {
        if (!$request->isXMLHttpRequest()) {
            return $this->json(
                [
                    'data' => 'Invalid request'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $users = $usersRepository->findByFirstName($request->request->get('firstName'));

        return new Response($serializer->serialize($users, 'json'));
    }
}