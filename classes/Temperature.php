<?php

abstract class Temperature extends Module
{
    
	/**
	 * @return array[self]
	 */
	public static function detect() : array
    {
        $res = [];
        $res = array_merge($res, NvmeTemp::detect());
        // array_merge($res, SataTemp::detect());
        return $res;
    }
	
	// public abstract function getValue(): string;

}
