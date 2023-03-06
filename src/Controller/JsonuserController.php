<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\UserType;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Repository\UserRepository;


class JsonuserController extends AbstractController
{
 

  #[Route('/user/signup', name: 'app_singup')]
  public function signupAction(Request $request, UserPasswordHasherInterface $passwordHasher)
  {
    $email = $request->query->get( key: "email");
    $password = $request->query->get( key: "password");
    $nom = $request->query->get( key: "nom");
    $prenom = $request->query->get( key: "prenom");
  //  $roles = $request->query->get( key: "roles");
  //  $roleuser = $request->query->get( key: "roleuser");
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        return new Response("email invalid");
    }

    $user = new User();
    $user->setEmail($email);
    $hashedPassword = $passwordHasher->hashPassword($user, $password);
    $user->setPassword($hashedPassword);
    $user->setNom($nom);
    $user->setPrenom($prenom);
    $user->setIsVerified(true);
   // $user->setRoleuser($roleuser);
  //  $user->setRoles(array($roles));
    

    try {
        $em =$this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return new JsonResponse("Account is created",200);//200 yani http result  ta3 server ok

    }catch(Exception $ex)
    {
        return new Response("exception".$ex->getMessage());
    }
  }
  #[Route('/user/signin', name: 'app_singin')]
  
  public function signinAction(Request $request) {
    $email= $request->query->get("email");
    $password= $request->query->get("password");

    $em= $this->getDoctrine()->getManager();
    $user= $em->getRepository(User::class)->findOneBy(['email'=>$email]);

    if($user)
    {
        if(password_verify($password,$user->getPassword()))
        {
            $serializer =new Serializer([new ObjectNormalizer()]);
            $formatted = $serializer->normalize($user);
            return new JsonResponse($formatted);
            //return?
        }
        else {
            return new Response("password not found");
        }
    }
      
      else{
        return new Response("user not found");
    }
  }

  #[Route('/user/editUser', name: 'app_gestion_profile')]
  public function editUser(Request $request, UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository)
  {
      $id = $request->get("id");
      $nom = $request->query->get("nom"); 
      $prenom = $request->query->get("prenom"); 
      $password = $request->query->get("password"); 
      $email = $request->query->get("email"); 
      
      $user = $userRepository->find($id);
      if ($nom === null) {
        // handle the null value here, for example, by setting a default value
        $nom = 'Default Name';
    }
      $user->setNom($nom);
      if ($prenom === null) {
        // handle the null value here, for example, by setting a default value
        $prenom = 'Default Name';
    }
      $user->setPrenom($prenom);
      $hashedPassword = $passwordHasher->hashPassword($user, $password);
      $user->setPassword($hashedPassword);
      $user->setEmail($email);
      $user->setIsVerified(true);
      
      try {
          $em = $this->getDoctrine()->getManager();
          $em->persist($user);
          $em->flush();
          return new JsonResponse("Success",200);//200 yani http result  ta3 server ok
  
      } catch(Exception $ex) {
          return new Response("Failed".$ex->getMessage());
      }
  }
 

}
