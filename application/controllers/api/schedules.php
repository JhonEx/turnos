<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Schedules extends REST_Controller
{
	function schedule_get()
    {
        try{
            if(!$this->get('id')){
            	$this->response(NULL, 400);
            }
            
            $schedule = $this->em->find('models\Schedules', $this->get('id'));
            
            if ($schedule){
                $this->response(array("status"=>true, "data"=>$schedule->toArray()), 200);
            } else {
                $this->response(array("status"=>false, 'error' => 'Register could not be found'), 404);
            }
        } catch (PDOException $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        } catch (Doctrine\DBAL\DBALException $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        } catch (Doctrine\ORM\ORMException $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        } catch (Exception $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        }
    }
    
    function schedule_post()
    {
        try {
            if (!$this->post("id")){
            	$this->response(NULL, 400);
            }
            
            if ($this->exist_turn($this->post('id'), $this->post('turn'), $this->post('date'))){
                $turn = $this->em->find('models\Turns', $this->post('turn'));
                $user = $this->em->find('models\UsersData', $this->post('user'));

                $schedule = $this->em->find('models\Schedules', $this->post("id"));
                $schedule->setDate(new DateTime($this->post('date')));
    			$schedule->setTurn($turn);
    			$schedule->setUser($user);
                $this->em->persist($schedule);
                $this->em->flush();
                $this->response(array('status' => true), 200);
            }else{
                $this->response(array('status' => false, 'exist' => 'exist_turn', 'error' => ''), 200);
            }
        
        } catch (PDOException $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        } catch (Doctrine\DBAL\DBALException $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        } catch (Doctrine\ORM\ORMException $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        } catch (Exception $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        }
    }

    function schedule_put()
    {
        try {
            if ($this->exist_turn(0, $this->put('turn'), $this->put('date'))){
                $turn = $this->em->find('models\Turns', $this->put('turn'));
                $user = $this->em->find('models\UsersData', $this->put('user'));
                
                $schedule = new models\Schedules();
                $schedule->setDate(new DateTime($this->put('date')));
    			$schedule->setTurn($turn);
    			$schedule->setUser($user);
                $this->em->persist($schedule);
                $this->em->flush();
                $id = $schedule->getId();
                $this->response(array('status' => true, 'id' => $id), 200);
            }else{
                $this->response(array('status' => false, 'exist' => 'exist_turn', 'error' => ''), 200);
            }
        } catch (PDOException $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        } catch (Doctrine\DBAL\DBALException $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        } catch (Doctrine\ORM\ORMException $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        } catch (Exception $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        }
    }

    function schedule_delete()
    {
        try {
            if (!$this->delete("id")){
            	$this->response(NULL, 400);
            }
            
            $id           = $this->delete("id");
            $schedule = $this->em->find('models\Schedules', $id);
        
            $this->em->remove($schedule);
            $this->em->flush();
            $this->response(array('status' => true), 200);
        } catch (PDOException $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        } catch (Doctrine\DBAL\DBALException $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        } catch (Doctrine\ORM\ORMException $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        } catch (Exception $e) {
            $this->response(array('status' => false, 'error' => $e->getMessage()), 400);
        }
    }
    
    function exist_turn($id, $turn, $date)
    {
        $this->loadRepository("Schedules");
        
        $schedule = new models\Schedules();
        $differentTurn  = true;
        $differentDate  = true;
        
        if ($id > 0) {
            $schedule = $this->em->find('models\Schedules', $id);
            $differentTurn  = ($turn != $schedule->getTurn()->getId());
            $differentDate  = ($date != $schedule->getDate()->format("Y-m-d"));
        }

        $edition    = ($id  > 0);
        $different  = ($differentDate || $differentTurn);
        $scheduleAux = $this->Schedules->findOneBy(array("turn" => $turn, "date" => new DateTime($date)));
        $exist      = (empty($scheduleAux) == false);
        $errorExist = ($edition && $different && $exist) || ($edition == false && $exist);
        
        return !$errorExist;
    }
}