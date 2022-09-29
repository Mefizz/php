<?php

declare(strict_types=1);

namespace App\Application\Http\RequestResolver;

use App\Application\Http\DTO\BaseDataObject;
use App\Application\Http\Validation\ValidationCheckerTrait;
use App\Infrastructure\Exceptions\InvalidRequestData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class RequestObjectResolver implements ArgumentValueResolverInterface
{
    use ValidationCheckerTrait;

    public function __construct(public DenormalizerInterface $serializer)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return is_subclass_of($argument->getType(), BaseDataObject::class);
    }

    /**
     * @throws ExceptionInterface
     * @throws InvalidRequestData
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $data  = [];
        $route = $request->get('_route');

        if ($route && (str_contains($route, 'admin'))) {
            $data = $request->request->all();
        } else if ($content = $request->getContent()) {
            $data = json_decode($content, true);
        }

        if (Request::METHOD_GET === $request->getMethod()) {
            $data = $request->query->all();
        }

        $dto = $this->serializer->denormalize($data, $argument->getType(), null, [
            'disable_type_enforcement' => true,
        ]);

        $this->validate($dto);

        yield $dto;
    }
}