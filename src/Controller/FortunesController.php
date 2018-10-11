<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Form\FortuneType;

use App\Entity\Fortune;


class FortunesController extends Controller
{

  /**
  * @Route("/fortunes/")
  */
  public function random()
  {
    $repo = $this->getDoctrine()->getRepository(Fortune::class);
    $fortune = $repo->findRandom();
    return $this->render(
      'fortunes/show.html.twig',
      array(
        'creationDate' => $fortune->getCreationDate()->format('c'),
        'content' => $fortune->getContent()
      )
    );
  }

  /**
  * @Route("/fortunes/last", name="last-fortune")
  */
  public function last()
  {
    $frepo = $this->getDoctrine()->getRepository(Fortune::class);

    $fortune = $frepo->findOneBy(
      [],
      [ 'creationDate' => 'DESC', ]
    );
    return $this->render('fortunes/show.html.twig',
      array(
        'creationDate' => $fortune->getCreationDate()->format('c'),
        'content' => $fortune->getContent()
      )
    );
  }

  /**
  * @Route("/fortunes/{id}", requirements={"id"="\d+"}))
  */
  public function one(Fortune $id) {
    $frepo = $this->getDoctrine()->getRepository(Fortune::class);

    $fortune = $frepo->find($id);
    return $this->render('fortunes/show.html.twig',
      array(
        'creationDate' => $fortune->getCreationDate()->format('c'),
        'content' => $fortune->getContent()
      )
    );
  }

  /**
  * @Route("/fortunes/new")
  * @todo Double form with double validation (https://symfony.com/doc/current/form/multiple_buttons.html)
  * @todo Fortune, FortuneText, FortuneImage ? (ou juste les 3 champs dans la même table, avec des validations?)
  */
  public function new(Request $request) {
    $fortune = new Fortune();

    $form = $this->createForm(FortuneType::class, $fortune);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $fortune = $form->getData();
      $em = $this->getDoctrine()->getManager();
      $em->persist($fortune);
      $em->flush();

      return $this->redirectToRoute('last-fortune');
    }

    return $this->render('fortunes/new.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * @Route("/fortunes/list/")
   */
  public function list() {
    $frepo = $this->getDoctrine()->getRepository(Fortune::class);

    $fortunes = $frepo->findAll();
    return $this->render('fortunes/show-list.html.twig',
      array(
        'fortunes' => array_map(
          function ($db_f) {
            return [
              'creationDate' => $db_f->getCreationDate()->format('c'),
              'content' => $db_f->getContent()
            ];
          },
          $fortunes
        )
      )
    );
  }

  /**
   * @Route("/fortunes/update")
   */
  public function update( Fortune $id ) {
  }
}
