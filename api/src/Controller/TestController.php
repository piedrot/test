<?php

namespace App\Controller;

use ApiPlatform\Core\Bridge\Symfony\Identifier\Normalizer\UuidNormalizer;
use App\Entity\Project;
use App\Serializer\Normalizer\SapDateTimeNormalizer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[Route( '/_test' )]
class TestController extends AbstractController
{
    /**
     * Renvoie les paramètres de finesse de saisie de temps
     */
    #[Route( '/', name: 'test' )]
    public function test(): Response
    {

        $payload = file_get_contents('/srv/api/tests/test.json');

        $classMetadataFactory = new ClassMetadataFactory( new AnnotationLoader( new AnnotationReader() ) );
        $objectNormalizer      = new ObjectNormalizer( $classMetadataFactory, null, null, new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]) );
        $normalizers      = [ new UuidNormalizer(), new SapDateTimeNormalizer(), new ArrayDenormalizer(), $objectNormalizer ];
        $serializer       = new Serializer( $normalizers, [new JsonEncoder()] );

        $test = $serializer->deserialize( $payload, Project::class, 'json', [
            AbstractNormalizer::GROUPS                         => ['project'],
            SapDateTimeNormalizer::FORMAT_KEY                  => "U.v",
        ] );

        dump($test);

        return $this->render( 'base.html.twig', [] );
    }
}
