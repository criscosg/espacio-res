<?php

namespace Res\ImageBundle\Form\Handler;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Res\ImageBundle\Form\Handler\ImageManager;
use Res\ImageBundle\Entity\Image;
use Res\EventBundle\Entity\Event;
use Res\ImageBundle\Entity\ImageEvent;
use Symfony\Component\Validator\Validator;

class CreateImageFormHandler
{
    private $imageManager;
    private $validator;

    public function __construct(ImageManager $imageManager, Validator $validator)
    {
        $this->imageManager = $imageManager;
        $this->validator = $validator;
    }

    public function handle(FormInterface $form, Request $request, Event $event)
    {
        if ($request->isMethod('POST')) {
            $imageConstraint = new \Symfony\Component\Validator\Constraints\Image();
            $form->bind($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $file = $data['file'];
                $imageConstraint->maxSizeMessage = Image::ERROR_MESSAGE;
                $imageConstraint->maxSize = Image::MAX_SIZE;
                $errorList = $this->validator->validateValue($file, $imageConstraint);
                if (count($errorList) == 0) {
                    $image->setFile($file);
                    $this->imageManager->createImage($image);
                } else {
                    return false;
                }

                return true;
            }
        }

        return false;
    }

    public function handleMultiple(FormInterface $formImg, Request $request, Event $event)
    {
        if ($request->getMethod() == 'POST') {
            $formImg->bind($request);
            $imageConstraint = new \Symfony\Component\Validator\Constraints\Image();
ldd($formImg);
            $files = $formImg->getData();
ldd($files);
            $files = $files['images'];
            $error = 0;
            if (!empty($files)) {
                foreach ($files as $file) {
                    $imageConstraint->minWidthMessage = 'La imagen debe tener un mínimo de ' . Image::MIN_WIDTH . ' píxeles de ancho';
                    $imageConstraint->minWidth = Image::MIN_WIDTH;
                    $imageConstraint->minWidthMessage =  'La imagen debe tener un mínimo de ' . Image::MIN_HEIGHT . ' píxeles de alto';
                    $imageConstraint->minHeight = Image::MIN_HEIGHT;
                    $imageConstraint->minWidthMessage =  'La imagen debe tener un mínimo de ' . Image::MIN_HEIGHT . ' píxeles de alto';
                    $imageConstraint->maxSizeMessage = Image::ERROR_MESSAGE;
                    $imageConstraint->maxSize = Image::MAX_SIZE;
                    $errorList = $this->validator->validateValue($file, $imageConstraint);
                    if (count($errorList) > 0) $error++;
ldd($errorLists);
                    if (get_class($file) == "Symfony\Component\HttpFoundation\File\UploadedFile" and (count($errorList) == 0)) {
                        try {
                            $image = new ImageEvent();
                            $image->setEvent($event);
                            $image->setFile($file);
                            $this->imageManager->saveImage($image);
                            $this->imageManager->createImage($image);
                        } catch (\Exception $e) {
                            $this->imageManager->removeImage($image);
                            return true;
                        }
                    }
                }
            }
            if ($error > 0) {
                return true;
            } else {
                return false;
            }
        }

        return true;
    }
}