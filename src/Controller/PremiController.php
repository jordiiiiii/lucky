<?php
// src/Controller/PremiController.php
namespace App\Controller;

use App\Entity\Premi;
use App\Entity\Organisme;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\OrganismeRepository;
use App\Repository\PremiRepository;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PremiController extends AbstractController
{
    /**
      * @Route("/lucky/number")
      */
    public function number(): Response
    {
        $number = random_int(0, 100);

//        return new Response(
//            '<html><body>Lucky number: '.$number.'</body></html>'
//        );
        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }
    /**
     * @Route("/", name="premi_list")
     * @Method({"GET"})
     */
    public function index() {
        $premis = $this->getDoctrine()->getRepository(Premi::class)->findAll();
        return $this->render('premis/index.html.twig', array('premis' => $premis));
    }

    /**
     * @Route("/organismes", name="organisme_list")
     * @Method({"GET"})
     */
    public function indexOrganisme() {
        $organismes = $this->getDoctrine()->getRepository(Organisme::class)->findAll();
        return $this->render('organismes/index.html.twig', array('organismes' => $organismes));
    }

    /**
     * @Route("/premi/nou", name="new_premi")
     * Method({"GET", "POST"})
     */
    public function new(Request $request) {
        $premi = new Premi();

        $organismes = $this->getDoctrine()->getRepository(Organisme::class)->findAll();

        $form = $this->createFormBuilder($premi)
            ->add('nom', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('valor', IntegerType::class, array(
                'required' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('data', DateType::class, array(
                'required' => true,
                'attr' => array('class' => 'form-control')
            ))
//            ->add('organisme', ChoiceType::class, ['choices'=> $organismes] , array(
//                'required' => true,
//                'attr' => array('class' => 'form-control')
//            ))
            ->add('organisme', EntityType::class, [
                'class' => Organisme::class,
                'choice_label' => 'nomorg'])
            ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $premi = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($premi);
            $entityManager->flush();

            return $this->redirectToRoute('premi_list');
        }

        return $this->render('premis/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/organisme/nou", name="new_organisme")
     * Method({"GET", "POST"})
     */
    public function newOrg(Request $request) {
        $organisme = new Organisme();

        $form = $this->createFormBuilder($organisme)
            ->add('nomorg', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('nif', TextType::class, array(
                'required' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $organisme = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($organisme);
            $entityManager->flush();

            return $this->redirectToRoute('organisme_list');
        }

        return $this->render('organismes/new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/premi/edit/{id}", name="edit_premi")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
//        $premi = new Premi();
        $premi = $this->getDoctrine()->getRepository(Premi::class)->find($id);

        $form = $this->createFormBuilder($premi)
            ->add('nom', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('valor', IntegerType::class, array(
                'required' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('data', DateType::class, array(
                'required' => true,
                'attr' => array('class' => 'form-control')
            ))
            ->add('save', SubmitType::class, array(
                'label' => 'Update',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $premi = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();

            return $this->redirectToRoute('premi_list');
        }

        return $this->render('premis/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/premi/{id}", name="premi_show")
     * @Method({"GET"})
     */
    public function show(int $id): Response
    {
        $premi = $this->getDoctrine()
            ->getRepository(Premi::class)
            ->find($id);

        return $this->render('premis/show.html.twig', array('premi' => $premi));
    }

    /**
     * @Route("/organisme/{id}", name="organisme_show")
     * @Method({"GET"})
     */
    public function showOrg(int $id): Response
//    public function showOrg(int $id, PremiRepository $premiRepository): Response
    {
        $organisme = $this->getDoctrine()
            ->getRepository(Organisme::class)
            ->find($id);

//        $premi = $premiRepository->findBy(['organisme' => $organisme]);
//        dump($premi);die;
        $premis = $organisme->getPremis();
        foreach($premis as $premi){
            dump($premi);
        }
        die;

        return $this->render('organismes/show.html.twig', array('organisme' => $organisme));
    }

    /**
     * @Route("/premi/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $premi = $this->getDoctrine()->getRepository(Premi::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($premi);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }

    /**
     * @Route("/organisme/delete/{id}")
     * @Method({"DELETE"})
     */
    public function deleteOrg(Request $request, $id) {
        $organisme = $this->getDoctrine()->getRepository(Organisme::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($organisme);
        $entityManager->flush();

        $response = new Response();
        $response->send();
    }

    /**
     * @Route("/premi/edit/{id}")
     */
    public function update(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $premi = $entityManager->getRepository(Premi::class)->find($id);

        if (!$premi) {
            throw $this->createNotFoundException(
                'No premi found for id '.$id
            );
        }

        $premi->setNom('New premi name!');
        $entityManager->flush();

        return $this->redirectToRoute('premi_show', [
            'id' => $premi->getId()
        ]);
    }

    /**
     * @Route("/organisme/edit/{id}")
     */
    public function updateOrg(int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $organisme = $entityManager->getRepository(Organisme::class)->find($id);

        if (!$organisme) {
            throw $this->createNotFoundException(
                'No Organisme found for id '.$id
            );
        }

        $organisme->setNomorg('New Organisme name!');
        $entityManager->flush();

        return $this->redirectToRoute('organisme_show', [
            'id' => $organisme->getId()
        ]);
    }

    /**
     * @Route("/yoyo")
     * @Method({"GET"})
     */
    public function yoyo(): Response
    {
        // from inside a controller
        $minPrice = 80;

        $premis = $this->getDoctrine()
            ->getRepository(Premi::class)
            ->findAllGreaterThanPrice($minPrice);

        return $this->render('premis/showmesalt.html.twig', array('premis' => $premis));

    }

    /**
     * @Route("/yoyo2")
     * @Method({"GET"})
     */
    public function yoyo2(): Response
    {
        // from inside a controller
        $minPrice = 0;

        $premis = $this->getDoctrine()
            ->getRepository(Premi::class)
            ->findAllGreaterThanPrice($minPrice);

        $nova = array_slice($premis, 0, 1);

        return $this->render('premis/showmesalt.html.twig', array('premis' => $nova));

    }

//    /**
//     * @Route("/premi", name="create_premi")
//     */
//    public function createPremi(): Response
//    {
//        // you can fetch the EntityManager via $this->getDoctrine()
//        // or you can add an argument to the action: createPremi(EntityManagerInterface $entityManager)
//        $entityManager = $this->getDoctrine()->getManager();
//
//        $premi = new Premi();
//        $premi->setNom('nommmm');
//        $premi->setValor(mt_rand(10, 100));
//        $premi->setData(new \DateTime());
//
//        // tell Doctrine you want to (eventually) save the Product (no queries yet)
//        $entityManager->persist($premi);
//
//        // actually executes the queries (i.e. the INSERT query)
//        $entityManager->flush();
//
//        return new Response('Saved new product with id '.$premi->getId());
//    }

//    /**
//     * @Route("/premi", name="create_premi")
//     */
//    public function createPremi(ValidatorInterface $validator): Response
//    {
//        // you can fetch the EntityManager via $this->getDoctrine()
//        // or you can add an argument to the action: createPremi(EntityManagerInterface $entityManager)
//        $entityManager = $this->getDoctrine()->getManager();
//
//        $premi = new Premi();
////        $premi->setNom('no2');
////        $premi->setValor(mt_rand(10, 100));
//
//        // This will trigger an error: the column isn't nullable in the database
//        $premi->setNom(null);
//        // This will trigger a type mismatch error: an integer is expected
//        $premi->setValor('1999');
//
//        $premi->setData(new \DateTime());
//
//        $errors = $validator->validate($premi);
//        if (count($errors) > 0) {
//            return new Response((string) $errors, 400);
//        }
//
//        // tell Doctrine you want to (eventually) save the Product (no queries yet)
//        $entityManager->persist($premi);
//
//        // actually executes the queries (i.e. the INSERT query)
//        $entityManager->flush();
//
//        return new Response('Saved new product with id '.$premi->getId());
//    }

}


