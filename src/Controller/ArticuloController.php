<?php
namespace App\Controller;
use App\Repository\ArticuloRepository;
use App\Repository\PetRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticuloController
 * @package App\Controller
 *
 * @Route(path="/api/")
 */
class ArticuloController
{
    private $articuloRepository;

    public function __construct(ArticuloRepository $articuloRepository)
    {
        $this->articuloRepository = $articuloRepository;        
    }

    /**
     * @Route("articulo", name="add_articulo", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $nombre = $data['name'];
        $codigo = $data['codigo'];
        $unidades = $data['unidades'];
        $referencia = $data['referencia'];

        if (empty($nombre) || empty($codigo) || empty($unidades) || empty($referencia)) {
            throw new NotFoundHttpException('Expecting mandatory parameters!');
        }

        $this->articuloRepository->saveArticulo($nombre, $codigo, $unidades, $referencia);

        return new JsonResponse(['status' => 'Artículo creado'], Response::HTTP_CREATED);
    }   
    
}