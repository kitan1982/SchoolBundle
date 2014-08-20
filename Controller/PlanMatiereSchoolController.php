<?php

namespace Laurent\SchoolBundle\Controller;

use Laurent\SchoolBundle\Entity\ChapitrePlanMatiere;
use Laurent\SchoolBundle\Entity\PlanMatiere;
use Laurent\SchoolBundle\Entity\PointMatiere;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration as EXT;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PlanMatiereSchoolController extends Controller
{

    /**
     * @EXT\Route("/pl", name="laurentSchoolPlanMatiereList")
     * @EXT\Template("LaurentSchoolBundle::planMatiereList.html.twig")
     */

    public  function planMatiereListAction()
    {
        $plRepository = $this->getDoctrine()->getRepository('LaurentSchoolBundle:PlanMatiere');
        $user = $this->get('security.context')->getToken()->getUser();
        $plmatieres = $plRepository->findUserPlanMatiere($user);

        return array('plmatieres'=> $plmatieres);
    }

    /**
     * @EXT\Route(
     *     "/pl/create/form",
     *     name="laurentSchoolPlanMatiereCreateForm",
     *     options = {"expose"=true}
     * )
     * @EXT\Method("GET")
     * @EXT\Template("LaurentSchoolBundle::planMatiereCreateForm.html.twig")
     *
     * Displays the admin homeTab form.
     *
     * @return Response
     */
    public function planMatiereCreateFormAction()
    {
        //$this->checkOpen();

        $form = $this->createFormBuilder()
            ->add('name', 'text', array('label' => 'Nom'))
            ->add(
                     'matiere',
                     'entity',
                     array(
                         'label' => 'Matière',
                         'class' => 'LaurentSchoolBundle:Matiere',
                         'property' => 'name',
                         'required' => false
                     )
                )
            ->getForm()
        ;

        return array('form' => $form->createView());
    }

    /**
     * @EXT\Route(
     *     "/pl/create",
     *     name="laurentSchoolPlanMatiereCreate",
     *     options = {"expose"=true}
     * )
     * @EXT\Method("POST")
     * @EXT\Template("LaurentSchoolBundle::planMatiereCreateForm.html.twig")
     *
     * Create a new Plan Matiere
     *
     * @return array|Response
     */
    public function planMatiereCreateAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('name', 'text', array('label' => 'Nom'))
            ->add(
                'matiere',
                'entity',
                array(
                    'label' => 'Matière',
                    'class' => 'LaurentSchoolBundle:Matiere',
                    'property' => 'name',
                    'required' => false
                )
            )
            ->getForm()
            ;
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->get('doctrine')->getManager();
            $planMatiere = new PlanMatiere;
            $planMatiere->setName($form["name"]->getData());
            $planMatiere->setMatiere($form["matiere"]->getData());
            $user = $this->get('security.context')->getToken()->getUser();
            $planMatiere->addProf($user);
            $em->persist($planMatiere);
            $em->flush();

            return new Response('success', 201);
        }
        return array('form' => $form->createView());
    }

    /**
     * @EXT\Route("/pl/{planMatiere}", name="laurentSchoolPlanMatiere")
     * @param PlanMatiere $planMatiere
     * @EXT\Template("LaurentSchoolBundle::planMatiere.html.twig")
     */

    public  function planMatiereAction(PlanMatiere $planMatiere)
    {
        $pl = $planMatiere;
        $chapitres = $this->getDoctrine()->getManager()->getRepository('LaurentSchoolBundle:ChapitrePlanMatiere')->findChapitrePlanMatiere($pl);
        $total = 0;
        foreach ($chapitres as $chapitre)
        {
            $total += $chapitre->getNbPeriode();
        }
        $matiere = $pl->getMatiere();
        $nbHsem = $matiere->getNbPeriode();
        $nbH = $nbHsem * 26;

        //$pointMatieres = $this->getDoctrine()->getManager()->getRepository('LaurentSchoolBundle:PointMatiere')->findAll();

        return array('pl' => $pl, 'nbH' => $nbH, 'chapitres' => $chapitres, 'total' => $total);
    }

    /**
     * @EXT\Route(
     *     "/pl/{planMatiere}/chap/create",
     *     name="laurentSchoolPlanMatiereChapCreate",
     *     options = {"expose"=true}
     * )
     * @EXT\Method("POST")
     * @EXT\Template("LaurentSchoolBundle::planMatiereCreateChapForm.html.twig")
     *
     * Create a new chapite in Plan Matiere
     *
     * @param PlanMatiere $planMatiere
     *
     * @return array|Response
     */
    public function planMatiereCreateChapAction(Request $request, PlanMatiere $planMatiere)
    {
        $mois = array('1' => 'Janvier',
                      '2' => 'Février',
                      '3' => 'Mars',
                      '4' => 'Avril',
                      '5' => 'Mai',
                      '6' => 'Juin',
                      '7' => 'Juillet',
                      '8' => 'Août',
                      '9' => 'Septembre',
                      '10' => 'Octobre',
                      '11' => 'Novembre',
                      '12' => 'Décembre');

        $form = $this->createFormBuilder()
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('nbPeriode', 'number', array('label'=> 'Nombre de période', 'required'  => false))
            ->add('ordre', 'number', array('label' => 'Ordre', 'required'  => false))
            ->add('annee', 'number', array('label' => 'Annee', 'required'  => false))
            ->add('moment', 'choice', array('label' => 'Moment', 'choices' => $mois, 'required'  => false))
            ->getForm()
        ;
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->get('doctrine')->getManager();
            $chapitre = new ChapitrePlanMatiere;
            $chapitre->setName($form["name"]->getData());
            $chapitre->setNbPeriode($form["nbPeriode"]->getData());
            $chapitre->setOrdre($form["ordre"]->getData());
            $chapitre->setMoment($form["moment"]->getData());
            $chapitre->setAnnee($form["annee"]->getData());
            $chapitre->setPlanMatiere($planMatiere);
            $em->persist($chapitre);

            $em->flush();

            return new Response('success', 201);
        }

        return array('form' => $form->createView(), 'pl' => $planMatiere);
    }

    /**
     * @EXT\Route(
     *     "/pl/{chap}/pm/create",
     *     name="laurentSchoolPlanMatierePMCreate",
     *     options = {"expose"=true}
     * )
     * @EXT\Method("POST")
     * @EXT\Template("LaurentSchoolBundle::planMatiereCreatePMForm.html.twig")
     *
     * Create a new chapite in Plan Matiere
     *
     * @param ChapitrePlanMatiere $chap
     *
     * @return array|Response
     */
    public function planMatiereCreatePointMatiereAction(Request $request, ChapitrePlanMatiere $chap)
    {

        $form = $this->createFormBuilder()
            ->add('name', 'text', array('label' => 'Nom'))
            ->add('nbPeriode', 'number', array('label'=> 'Nombre de période', 'required'  => false))
            ->add('ordre', 'number', array('label' => 'Ordre', 'required'  => false))
            ->getForm()
        ;
        $form->handleRequest($request);


        if ($form->isValid()) {
            $em = $this->get('doctrine')->getManager();
            $pm = new PointMatiere;
            $pm->setName($form["name"]->getData());
            $pm->setNbPeriode($form["nbPeriode"]->getData());
            $pm->setOrdre($form["ordre"]->getData());
            $pm->addChapitre($chap);
            $em->persist($pm);
            $em->flush();

            return new Response('success', 201);
        }

        return array('form' => $form->createView(), 'chap' => $chap);
    }


}