<?php

abstract class Module
{
	
	private $name;
	
	public function __construct(string $name)
	{
		$this->name = $name;
	}
	
	public static function __set_state($array)
    {
		$res = new static($array["name"]);
        return $res;
    }
	
	// public abstract static function detect(): array;
	/**
	 * @return array[self]
	 */
	public static function detect() : array
	{
		return Temperature::detect();
	}
	
	abstract static function getType() : string;
	
	public function getName(): string
	{
		return $this->name;
	}
	
	// public abstract function getValue(): string;

}
