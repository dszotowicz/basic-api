<?php

declare(strict_types=1);

namespace App\Subscriber;

use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UniqueEmployeeSubscriber implements EventSubscriberInterface
{
    /**
     * @var EmployeeRepository
     */
    private $repository;

    public function __construct(EmployeeRepository $repository)
    {
        $this->repository = $repository;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SUBMIT => 'postSubmit'
        ];
    }

    public function postSubmit(FormEvent $event)
    {
        /** @var Employee $employee */
        $employee = $event->getData();
        $form = $event->getForm();

        $existing = $this->repository->findByPhoneNumber($employee->getPhoneNumber());

        if (!$existing) {
            return;
        }

        if (!$employee->getId()) {
            $form->addError(new FormError('Phone number is already registered.'));
            return;
        }

        if ($employee->getId() !== $existing->getId()) {
            $form->addError(new FormError('Phone number is already in use.'));
        }
    }
}