<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManager;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;

#[Route(path: 'contact', name: 'contact')]
class ContactController extends AbstractController
{

  private $serializer;

  public function __construct(EntityManagerInterface $entityManagerInterface)
  {
    $encoders = [new XmlEncoder(), new JsonEncoder()];
    $normalizers = [new ObjectNormalizer()];
    $this->serializer = new Serializer($normalizers, $encoders);
  }

  #[Route(path: '/post', name: '_post', methods: ['POST'])]
  public function contact(Request $request, ?ManagerRegistry $managerRegistry): Response
  {
    $contact = new Contact();
    $data = json_decode($request->getContent());
    foreach ($data as $key => $value) {
      if (isset($key)) {
        $function = 'set' . $key;
        $contact->$function($value);
      }
    }
    $entityManager = $managerRegistry->getManager();
    $entityManager->persist($contact);
    $entityManager->flush();
    $contact = $managerRegistry->getRepository(Contact::class)->find($contact->getId());
    $jsonContent = $this->serializer->serialize($contact, 'json');
    $response = new Response($jsonContent, 200);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  #[Route(path: '/get', name: '_get', methods: ['GET'])]
  public function getContacts(ContactRepository $contactRepository): Response
  {
    $contacts = $contactRepository->findAll();
    $jsonContent = $this->serializer->serialize($contacts, 'json');
    $response = new Response($jsonContent, 200);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  #[Route(path: '/get/{id}', name: '_get_by_id', methods: 'GET')]
  public function getContactById(int $id, ManagerRegistry $managerRegistry): Response
  {
    $contact = $managerRegistry->getRepository(Contact::class)->find($id);
    $jsonContent = $this->serializer->serialize($contact, 'json');
    $response = new Response($jsonContent, 200);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  #[Route(path: '/put/{id}', name: '_put_by_id', methods: 'PUT')]
  public function putContactById(int $id, ManagerRegistry $managerRegistry, Request $request): Response
  {
    $contact = $managerRegistry->getRepository(Contact::class)->find($id);
    $data = json_decode($request->getContent());
    foreach ($data as $key => $value) {
      if (isset($key)) {
        $function = 'set' . $key;
        $contact->$function($value);
      }
    }
    $entityManager = $managerRegistry->getManager();
    $entityManager->persist($contact);
    $entityManager->flush();
    $contact = $managerRegistry->getRepository(Contact::class)->find($id);
    $jsonContent = $this->serializer->serialize($contact, 'json');
    $response = new Response($jsonContent, 200);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  #[Route(path: '/patch/{id}', name: '_patch_by_id', methods: 'PATCH')]
  public function patchContactById(int $id, ManagerRegistry $managerRegistry, Request $request): Response
  {
    $contact = $managerRegistry->getRepository(Contact::class)->find($id);
    $data = json_decode($request->getContent());
    foreach ($data as $key => $value) {
      if (isset($key)) {
        $function = 'set' . $key;
        $contact->$function($value);
      }
    }
    $entityManager = $managerRegistry->getManager();
    $entityManager->persist($contact);
    $entityManager->flush();
    $contact = $managerRegistry->getRepository(Contact::class)->find($id);
    $jsonContent = $this->serializer->serialize($contact, 'json');
    $response = new Response($jsonContent, 200);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

  #[Route(path: '/delete/{id}', name: '_delete_by_id', methods: 'DELETE')]
  public function contactId(int $id, ManagerRegistry $managerRegistry): Response
  {
    $contact = $managerRegistry->getRepository(Contact::class)->find($id);
    if (!$contact) {
      $response = new Response('null', 200);
      $response->headers->set('Content-Type', 'application/json');
      return $response;
    }
    $entityManager = $managerRegistry->getManager();
    $entityManager = $managerRegistry->getManager();
    $entityManager->remove($contact);
    $entityManager->flush();
    $response = new Response('success', 200);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }
}
