<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Employee;
use App\Form\Type\EmployeeListType;
use App\Form\Type\EmployeeType;
use App\Repository\EmployeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use FOS\RestBundle\Controller\Annotations as Rest;
use OpenApi\Annotations as OA;

class EmployeeController extends AbstractFOSRestController
{
    /**
     * @OA\Parameter(
     *     name="page",
     *     in="query",
     *     description="selected page of pagination",
     *     required=true,
     *     @OA\Schema(
     *         type="integer",
     *         minimum=1
     *     )
     * )
     * @OA\Parameter(
     *     name="limit",
     *     in="query",
     *     description="maximum number of results to return",
     *     required=true,
     *     @OA\Schema(
     *         type="integer",
     *         maximum=100,
     *         minimum=1
     *     )
     * )
     * @OA\Response(
     *     response=200,
     *     description="returns list of employees",
     *     @OA\JsonContent(
     *         @OA\Property(property="currentPage", type="integer"),
     *         @OA\Property(property="lastPage", type="integer"),
     *         @OA\Property(
     *             property="employees",
     *             type="array",
     *             @OA\Items(ref=@Model(type=Employee::class, groups={"read"}))
     *         )
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Invalid parameters"
     * )
     * @OA\Tag(name="employees")
     * @Rest\View(serializerGroups={"read"})
     * @Rest\Get("/employees", name="api_employee_list")
     */
    public function listEmployees(Request $request, EmployeeRepository $repository, PaginatorInterface $paginator)
    {
        $form = $this->createForm(EmployeeListType::class);
        $form->submit($request->query->all());

        if(!$form->isValid()) {
            return $this->handleView($this->view($form, Response::HTTP_BAD_REQUEST));
        }

        $paginated = $paginator->paginate(
            $repository->createQueryBuilder('e'),
            $form->get('page')->getData(),
            $form->get('limit')->getData()
        );

        return $this->handleView(
            $this->view(
                [
                    "currentPage" => $paginated->getCurrentPageNumber(),
                    "lastPage" => ceil($paginated->getTotalItemCount() / $paginated->getItemNumberPerPage()),
                    "employees" => $paginated->getItems()
                ],
                Response::HTTP_OK
            )
        );
    }

    /**
     * @OA\RequestBody(
     *     description="data of new employee",
     *     required=true,
     *     @OA\JsonContent(ref=@Model(type=Employee::class, groups={"save"}))
     * )
     * @OA\Response(
     *     response=201,
     *     description="returns ID of created employee",
     *     @OA\JsonContent(
     *         @OA\Property(property="id", type="integer")
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Invalid employee data"
     * )
     * @OA\Tag(name="employees")
     * @Rest\Post("/employees", name="api_employee_create")
     */
    public function createEmployee(Request $request, EntityManagerInterface $entityManager)
    {
        $employee = new Employee();
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->submit($request->request->all());

        if(!$form->isValid()) {
            return $this->handleView($this->view($form, Response::HTTP_BAD_REQUEST));
        }

        $entityManager->persist($employee);
        $entityManager->flush();

        return $this->handleView(
            $this->view(
                [
                    'id' => $employee->getId()
                ],
                Response::HTTP_CREATED
            )
        );
    }

    /**
     * @OA\Parameter(
     *     name="employee",
     *     in="path",
     *     description="ID of employee that needs to be fetched",
     *     required=true,
     *     @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     *     response=200,
     *     description="returns data of employee",
     *     @OA\JsonContent(ref=@Model(type=Employee::class, groups={"read"}))
     * )
     * @OA\Response(
     *     response=400,
     *     description="Invalid ID supplied"
     * )
     * @OA\Response(
     *     response=404,
     *     description="Employee not found"
     * )
     * @OA\Tag(name="employees")
     * @Rest\Get("/employees/{employee}", name="api_employee_read")
     */
    public function readEmployee(Request $request, Employee $employee)
    {
        return $this->handleView(
            $this->view($employee, Response::HTTP_OK)
        );
    }

    /**
     * @OA\Parameter(
     *     name="employee",
     *     in="path",
     *     description="ID of employee that needs to be updated",
     *     required=true,
     *     @OA\Schema(type="integer")
     * )
     * @OA\RequestBody(
     *     description="data of employee to be replaced",
     *     required=true,
     *     @OA\JsonContent(ref=@Model(type=Employee::class, groups={"save"}))
     * )
     * @OA\Response(
     *     response=200,
     *     description="Employee successfully updated"
     * )
     * @OA\Response(
     *     response=400,
     *     description="Invalid ID supplied"
     * )
     * @OA\Response(
     *     response=404,
     *     description="Employee not found"
     * )
     * @OA\Tag(name="employees")
     * @Rest\Put("/employees/{employee}", name="api_employee_update")
     */
    public function updateEmployee(Request $request, Employee $employee, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(EmployeeType::class, $employee);
        $form->submit($request->request->all());

        if(!$form->isValid()) {
            return $this->handleView($this->view($form, Response::HTTP_BAD_REQUEST));
        }

        $entityManager->persist($employee);
        $entityManager->flush();

        return $this->handleView(
            $this->view(null,Response::HTTP_OK)
        );
    }

    /**
     * @OA\Parameter(
     *     name="employee",
     *     in="path",
     *     description="ID of employee that needs to be deleted",
     *     required=true,
     *     @OA\Schema(type="integer")
     * )
     * @OA\Response(
     *     response=204,
     *     description="Employee successfully deleted"
     * )
     * @OA\Response(
     *     response=400,
     *     description="Invalid ID supplied"
     * )
     * @OA\Response(
     *     response=404,
     *     description="Employee not found"
     * )
     * @OA\Tag(name="employees")
     * @Rest\Delete("/employees/{employee}", name="api_employee_delete")
     */
    public function deleteEmployee(Request $request, Employee $employee, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($employee);
        $entityManager->flush();

        return $this->handleView($this->view(null, Response::HTTP_NO_CONTENT));
    }
}