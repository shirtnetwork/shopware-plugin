<?php


namespace Aggrosoft\Shopware\ShirtnetworkPlugin\Core\Content\Shirtnetwork\SalesChannel;


use OpenApi\Annotations as OA;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\DataAbstractionLayer\Search\Criteria;
use Shopware\Core\Framework\Plugin\Exception\DecorationPatternException;
use Shopware\Core\Framework\Routing\Annotation\Entity;
use Shopware\Core\Framework\Routing\Annotation\RouteScope;
use Shopware\Core\System\SalesChannel\SalesChannelContext;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @RouteScope(scopes={"store-api"})
 */
class ShirtnetworkRoute extends AbstractShirtnetworkRoute
{
    /**
     * @var EntityRepositoryInterface
     */
    protected $exampleRepository;

    public function __construct(EntityRepositoryInterface $exampleRepository)
    {
        $this->exampleRepository = $exampleRepository;
    }

    public function getDecorated(): AbstractShirtnetworkRoute
    {
        throw new DecorationPatternException(self::class);
    }

    /**
     * @Entity("swag_example")
     * @OA\Post(
     *      path="/example",
     *      summary="This route can be used to load the swag_example by specific filters",
     *      operationId="readExample",
     *      tags={"Store API", "Example"},
     *      @OA\Parameter(name="Api-Basic-Parameters"),
     *      @OA\Response(
     *          response="200",
     *          description="",
     *          @OA\JsonContent(type="object",
     *              @OA\Property(
     *                  property="total",
     *                  type="integer",
     *                  description="Total amount"
     *              ),
     *              @OA\Property(
     *                  property="aggregations",
     *                  type="object",
     *                  description="aggregation result"
     *              ),
     *              @OA\Property(
     *                  property="elements",
     *                  type="array",
     *                  @OA\Items(ref="#/components/schemas/swag_example_flat")
     *              )
     *          )
     *     )
     * )
     * @Route("/store-api/example", name="store-api.example.search", methods={"GET", "POST"})
     */
    public function load(Criteria $criteria, SalesChannelContext $context): ExampleRouteResponse
    {
        return new ExampleRouteResponse($this->exampleRepository->search($criteria, $context->getContext()));
    }
}
