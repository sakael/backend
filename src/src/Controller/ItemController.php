<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\{Response, Request};
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use App\Entity\Item;

#[Route('/items', name: 'items_')]
class ItemController extends AbstractController
{
    private $em;
    private $serializer;

    public function __construct(ManagerRegistry $em)
    {
        $this->em = $em;
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    #[Route(path: "", name: "index", methods: ["GET"])]
    public function index(): Response
    {
        $repository = $this->em->getRepository(Item::class);
        $items = $repository->findAll();
        $items = $this->serializer->serialize($items, 'json');
        return $this->json(['status' => 'success', 'items'=>$items], 200, ["Content-Type" => "application/json"]);
    }

    #[Route(path: "/create", name: "create", methods: ["POST"])]
    public function create(ValidatorInterface $validator, Request $request): Response
    {

        $item = new Item($request->request->get('name', ''), $request->request->get('phoneNumber', ''), $request->request->get('description', ''));
        $errors = $validator->validate($item);
        $entityManager = $this->em->getManager();
        if (count($errors) > 0) {
            return $this->json(['response' => 'failed'], 200, ["Content-Type" => "application/json"]);
        }
        $entityManager->persist($item);
        $entityManager->flush();
        return $this->json(['response' => 'success', 'ItemId' => $item->getId()], 200, ["Content-Type" => "application/json"]);
    }
}
