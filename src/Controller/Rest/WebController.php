<?php
namespace App\Controller\Rest;

use App\Entity\Users;
use App\Form\UserType;
use App\Repository\UsersRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class WebController extends AbstractFOSRestController
{
    /**
     * @Rest\Post("/create-user")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createUser(Request $request, UsersRepository $usersRepository)
    {
        $data = json_decode($request->getContent(), true);

        if ($data != true) {
            return $this->json(
                [
                    'title' => 'There was a validation error',
                    'error' => 'Invalid format json'
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        $user = new Users();

        $form = $this->createForm(UserType::class, $user);

        if (!empty($data['phoneNumbers'])) {
            $data['phoneNumbers'] = serialize($data['phoneNumbers']);
        }

        $form->submit($data);

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $this->getErrorsFromForm($form);

            return $this->json([
                'title' => 'There was a validation error',
                'errors' => $errors
            ]);
        }

        try {
            $usersRepository->hydrate($data);

            return $this->json([
                'message' => 'User created'
            ]);

        } catch (\Exception $e) {

            return $this->json([
                'message' => $e->getMessage(),
                'code'  => $e->getCode()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @param FormInterface $form
     * @return array
     */
    private function getErrorsFromForm(FormInterface $form)
    {
        $errors = array();
        foreach ($form->getErrors() as $error) {
            $errors[] = $error->getMessage();
        }
        foreach ($form->all() as $childForm) {
            if ($childForm instanceof FormInterface) {
                if ($childErrors = $this->getErrorsFromForm($childForm)) {
                    $errors[$childForm->getName()] = $childErrors;
                }
            }
        }
        return $errors;
    }
}