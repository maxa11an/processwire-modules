<?php


namespace ProcessWire;


class ProcessBodyRenderHelper
{
    static public function render($value){
        if(is_object($value)){
            $methodName = \ProcessWire\WireArray::new(explode('\\', get_class($value)))->last;
            $call = self::class.'::output'.$methodName;

            if(is_callable($call)){
                return $call($value);
            }
            if(wire()->config->debug){
                throw new \Exception("Missing a output in ".wire()->config->paths->self." for ".get_class($value));
            }
            return $value;
        }elseif(is_array($value)){
            return self::renderFinal(array_map(function($a){
                $methodName = \ProcessWire\WireArray::new(explode('\\', get_class($a)))->last;
                $call = self::class.'::output'.$methodName;
                if(is_callable($call)){
                    return $call($a);
                }
                if(wire()->config->debug){
                    throw new \Exception("Missing a output in ".wire()->config->paths->self." for ".get_class($a));
                }
                return $a;
            }, $value));
        }


        return $value;

    }

    static private function renderFinal($value){
        if(is_array($value) && !is_object($value[0])){
            return count($value) === 1 ? $value[0] : $value;
        }

        return $value;
    }


    private static function outputSelectableOptionArray(\ProcessWire\SelectableOptionArray $value){
        return self::render($value->getValues());
    }

    private static function outputSelectableOption(SelectableOption $value){
        return [
            "title" => $value->getTitle(),
            "value" => $value->getValue() ?? $value->get('id') ?? null
        ];
    }

}