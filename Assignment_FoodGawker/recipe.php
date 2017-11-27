<?php

/**
 * Description of recipe
 *
 * @author Dimitri, Renuchan
 */
class recipe {
    

	private $name;
	private $title;
	private $description;
	private $link;
	private $view;	
	
	public function __construct()
	{
            
	}	
	
	public function getName(){
            return $this -> name; 
	}
	public function getTitle(){
		return $this -> title; 
	}
	public function getDes(){
		return $this -> description; 
	}
	public function getLink(){
		return $this -> link; 
	}
	public function getView(){
		return $this -> view; 
	}
	

}
