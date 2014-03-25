<?php

namespace Res\FrontendBundle\Twig\Extension;
use Twig_Environment as Environment;

class BxSliderExtension extends CustomTwigExtension
{

    protected $twig;
    protected $assetFunction;

    public function initRuntime(Environment $twig)
    {
        $this->twig = $twig;
    }

    protected function asset($asset)
    {
        if (empty($this->assetFunction)) {
             $this->assetFunction = $this->twig->getFunction('asset')->getCallable();
        }
        return call_user_func($this->assetFunction, $asset);
    }

    public function getFunctions()
    {
        return array('drawBxSlider' => new \Twig_Function_Method($this, 'drawBxSlider'));
    }

    public function drawBxSlider($imgs)
    {

        $out = $this->_loadInitCSS();
        $out .= $this->_loadInitJS();
        $out .= $this->_loadBxSliderJS($imgs);

        $out .= '<ul class="bxslider">';
        foreach($imgs as $i){
            $out .= '<li><img src="'.$this->asset($i['image']).'" /></li>';
        }
        $out .= '</ul>';
        return $out;
    }

    private function _loadInitCSS(){
        return '<link rel="stylesheet" href="'.$this->asset('bundles/frontend/css/bxslider/jquery.bxslider.css').'">';
    }

    private function _loadInitJS(){
        return '<script src="'.$this->asset('bundles/frontend/js/bxslider/jquery.bxslider.js').'"></script>';
    }

    private function _loadBxSliderJS($imgs){
        $out = '<script>$(document).ready(function(){$(\'.bxslider\').bxSlider({';
        $coma = '';
        if(count($imgs) == 1){
            $out .='\'pager\':false';
        }else{
            $out .='\'imagesPager\':[';
            foreach($imgs as $i){
                $out .= $coma.'\''.$this->asset($i['thumb']).'\'';
                $coma = ',';
            }
            $out .=']';            
        }
        $out .='});});</script>';
        return $out;
    }

    public function getName()
    {
        return 'bxslider_extension';
    }
    
}