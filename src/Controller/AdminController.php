<?php

namespace App\Controller;

use App\Entity\Usine;
use App\Form\UsineType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpClient\HttpClient;

class AdminController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    public function addFile(Request $request, SluggerInterface $slugger): Response
    {
        $usine = new Usine();
        $form = $this->createForm(UsineType::class, $usine);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $stockFile */
            $stockFile = $form->get('file')->getData();
            $name = $form->get('name')->getData();

            if ($stockFile) {
                $originalFilename = pathinfo($stockFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $stockFile->guessExtension();

            
                try {
                    $stockFile->move(
                        $this->getParameter('dl_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // todo 
                }

                $usine->setFile($newFilename);
                $usine->setName($name);

                $em = $this->getDoctrine()->getManager();
                $em->persist($usine);
                $em->flush();

                $this->fileTreatment($newFilename);
            }
        }

        return $this->render('admin/file.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /** 
     * Need to export into dedicated class /DataPersister ?
     * todo : finalize it
     */
    public function fileTreatment($file)
    {                    
        $file = $this->getParameter('dl_directory').'/'.$file;

        $httpClient = HttpClient::create();
/*        $response = $httpClient->request('GET', 'https://api.github.com/repos/symfony/symfony-docs');
        $statusCode = $response->getStatusCode();*/
 
        $elements = file($file);

        foreach ($elements as $count => $element) {
            if($count == 0)
                continue;
            
            $data = explode(',', $element);
            $body =  [
                'uuid' => $data[4],
                'firstname' => $data[5],
                'lastname' => $data[6],
                'country' => $data[7]
            ];

            $response = $httpClient->request('POST', $this->getParameter('api_post_receiver'),['body' =>$body]);
            $statusCode = $response->getStatusCode();
            
            var_export($statusCode);
            
            if($statusCode == 400)
                break;
        }
                
    }
}
