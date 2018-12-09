<?php

namespace App\Controller;

use App\Entity\GiftsList;
use App\Form\GiftType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Gift;
use Symfony\Component\HttpFoundation\JsonResponse;

class GiftController extends AbstractController
{

    /**
     * @Route("/", name="homepage")
     */
    public function new(Request $request) {
        if($this->getUser() === null || !$this->getUser()->getIsActive()) {

            return $this->redirectToRoute('connexion');
        }

        // Edition d'un cadeau
        if($request->request->get('id')) {
            $id = $request->request->get('id');
            $gift = $this->getDoctrine()
                ->getRepository(Gift::class)
                ->findOneById($id);
            if($gift !== null) {
                return new JsonResponse(['id' => $gift->getId(), 'name' => $gift->getName(), 'description' => $gift->getDescription(), 'source' => $gift->getSource()]);
           }
        }
        $gift = new Gift();
        $form = $this->createForm(GiftType::class, $gift, [
            'attr' => ['class' => 'form-addGift'],
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gift = $form->getData();
            $giftslist = $this->getDoctrine()
                ->getRepository(GiftsList::class)
                ->findByUser($this->getUser()->getId());

           // L'utilisateur possède une giftslist
            $gift->setStatus(false);
            $gift->setUsername($this->getUser()->getUsername());
            $gift->setCreatedAt(new \DateTime('now'));
            if($giftslist) {
                $gift->setGiftslist($giftslist[0]);
            }
            // L'utilisateur n'a pas encore de giftlist
            else {
                $giftslist = new GiftsList();
                $gift->setGiftslist($giftslist);
                $giftslist->setUser($this->getUser());
                $gift->setGiftslist($giftslist);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gift);
            $entityManager->flush();
            return $this->redirectToRoute('homepage');
        }

        // Listing des cadeaux
        $gifts = $this->getDoctrine()
            ->getRepository(Gift::class)
            ->findByUsername($this->getUser()->getUsername());
        return $this->render('gift/index.html.twig', array(
            'form' => $form->createView(),
            'gifts' => $gifts
        ));
    }
    /**
     * @Route("/gifts", name="gifts")
     */
    public function allGifts()
    {
        $gifts = $this->getDoctrine()
        ->getRepository(Gift::class)
        ->getGiftsExceptSelf($this->getUser()->getUsername());
        return $this->render('gift/gifts.html.twig', [
            'controller_name' => 'GiftController',
            'gifts' => $gifts
        ]);
    }

//    /**
//     * @Route("/edit/{id}", name="editMyGift")
//     */
//    public function editGift($id, Request $request)
//    {
//        $gift = $this->getDoctrine()
//            ->getRepository(Gift::class)
//            ->findOneById($id);
//        if($gift !== null) {
//            $form = $this->createForm(GiftType::class, $gift, [
//                    'attr' => ['class' => 'form-addGift'],
//                    'data' => [
//                        'editing' => true,
//                        'name' => $gift->getName(),
//                        'description' => $gift->getDescription(),
//                        'source' => $gift->getSource(),
//                        'gift' => $gift
//                    ]
//                ]
//            );
//            $form->handleRequest($request);
//
//            if ($form->isSubmitted() && $form->isValid()) {
//                $gift = $form->getData();
//                $giftObj = $form->getData()['gift'];
//                $giftObj->setName($gift['name']);
//                $giftObj->setDescription($gift['description']);
//                $giftObj->setSource($gift['source']);
//                $entityManager = $this->getDoctrine()->getManager();
//                $entityManager->persist($giftObj);
//                $entityManager->flush();
//                return $this->redirectToRoute('homepage');
//            }
//        } else {
//            return $this->redirectToRoute('homepage');
//        }
//
//        return $this->render('gift/edit.html.twig', [
//            'controller_name' => 'GiftController',
//            'form' => $form->createView()
//        ]);
//    }
    /**
     * @Route("/edit/{id}", name="editMyGift")
     */
    public function editGift($id)
    {
        if(isset($_GET['gift-name']) && isset($_GET['gift-source']) && isset($_GET['gift-description']) && isset($id)) {
            $name = htmlspecialchars($_GET['gift-name']);
            $source = htmlspecialchars($_GET['gift-source']);
            $description = htmlspecialchars($_GET['gift-description']);

            $giftToEdit = $this->getDoctrine()
                ->getRepository(Gift::class)
                ->findOneById($id);
            if ($giftToEdit !== null) {
                $giftToEdit->setName($name);
                $giftToEdit->setDescription($description);
                $giftToEdit->setSource($source);
                $giftToEdit->setUpdatedAt(new \DateTime('now'));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($giftToEdit);
                $entityManager->flush();
                return $this->redirectToRoute('homepage');

            }
        } else {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('gift/edit.html.twig', [
            'controller_name' => 'GiftController',
        ]);
    }
    /**
     * @Route("/delete/{id}", name="deleteMyGift")
     */
    public function deleteGift($id)
    {
        return $this->render('gift/edit.html.twig', [
            'controller_name' => 'GiftController',
        ]);
    }

}
