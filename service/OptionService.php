<?php

namespace app\service;

use app\dto\OptionResponseDto;
use app\models\OptionEntity;
use app\models\repository\OptionRepository;
use Ramsey\Uuid\Uuid;
use RuntimeException;

class OptionService
{
    private OptionRepository $optionRepository;
    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }


    /**
     * @return OptionResponseDto[]
     */
    public function getAllOptionByQuestionId($id): array
    {
        $options = [];
        $optionList = $this->optionRepository->getAllOptionByQuestionId($id);
        foreach ($optionList as $option) {
            $optionResponse = new OptionResponseDto($option['id'], $option['title']);
            $options[] = $optionResponse->toArray();
        }
        return $options;
    }

    public function createOption(OptionEntity $option): void
    {
        $this->optionRepository->createOption($option);
    }

    public function createOptionByQuestionId(string $questionId, array $options): void
    {
        var_dump($questionId);
        foreach ($options as $option){
            $optionEntity = new OptionEntity(Uuid::uuid4(), $questionId, $option['title'], 0);
            $this->optionRepository->createOption($optionEntity);
        }
    }

    public function updateOption($questionId, $newOptions): void
    {
        $oldOptions = $this->optionRepository->getAllOptionByQuestionId($questionId);
        $optionToUpdate = [];
        foreach ($oldOptions as $oldOption) {
            $oldOptionId = $oldOption['id'];
            $option = array_filter($newOptions, function ($o) use ($oldOptionId) {
                return isset($o['id']) && $oldOptionId === $o['id'];
            });
            $option && $optionToUpdate[] = $option;
        }
        $newOptionToAdd[] = array_filter($newOptions, function ($o) {
            return !array_key_exists('id', $o);
        });
        $optionToDelete[] = array_udiff($oldOptions, $newOptions, function ($a, $b) {
            $idA = $a['id'] ?? null;
            $idB = $b['id'] ?? null;
            return $idA <=> $idB;
        });
            if(!empty($optionToUpdate)){
                foreach ($optionToUpdate as $optionData){
                    foreach ($optionData as $option){
                        $optionUpdateEntity = new OptionEntity($option['id'], $questionId, $option['title'], 0);
                        $this->optionRepository->updateOption($optionUpdateEntity);
                    }
                }
            }

            if(!empty($newOptionToAdd)){
                foreach ($newOptionToAdd as $optionData){
                    foreach ($optionData as $option){
                        $optionCreateEntity = new OptionEntity(Uuid::uuid4(), $questionId, $option['title'], 0);
                        var_dump("add option");
                        $this->optionRepository->createOption($optionCreateEntity);
                    }
                }
            }

            if(!empty($optionToDelete)){
               foreach ($optionToDelete as $optionData){
                    foreach ($optionData as $option){
                        $this->optionRepository->delete($option['id']);
                    }
                }

            }


    }

    public function updateOptionRecord($id): bool
    {
       $isUpdated = $this->optionRepository->updateOptionRecord($id);
       return $isUpdated ? true : throw new RuntimeException("Cannot send this record, please try again!");
    }

    public function deleteOptionByQuestionId($id): void
    {
        $this->optionRepository->deleteOptionByQuestionId($id);
    }
}