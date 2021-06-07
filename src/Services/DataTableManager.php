<?php

namespace App\Services;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DataTableManager
{
    public function renderDataTable(Request $request, $repository, PaginatorInterface $paginator, $additionalFilter = [])
    {
        $startPage = $request->get('start');
        $order = $request->get('order')[0];
        $search = $request->get('search')['value'];
        $limit = $request->get('length');
        $page = ($startPage / $limit) + 1;
        $tableAdditionalFilter = $request->get('additionalFilters') ?? [];
        $additionalFilter = array_merge($additionalFilter, $tableAdditionalFilter);
        if (!empty($additionalFilter)) {
            $data = $repository->getDataTableListings($order, $search, $additionalFilter);
        } else {
            $data = $repository->getDataTableListings($order, $search);
        }

        $pagination = $paginator->paginate(
            $data,
            $request->query->getInt('page', $page),
            $limit
        );

        $tableData = [];
        $totalCount = $pagination->getTotalItemCount();
        if ($totalCount > 0) {
            $encoders = [new JsonEncoder()];
            $normalizers = [new ObjectNormalizer()];

            $serializer = new Serializer($normalizers, $encoders);
            foreach ($pagination as $entity) {
                $entityJson = $serializer->serialize($entity, 'json');
                $entityArray = $serializer->decode($entityJson, 'json');
                $entityArray['action'] = '';
                $tableData[] = $entityArray;
            }
        }

        return [
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $totalCount,
            'data' => $tableData,
        ];
    }
}
