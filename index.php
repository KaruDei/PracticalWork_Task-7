<?php
	abstract class Planes {
		public $name;
		public $maxSpeed;
		public $fly = false;
		public $status;
		public $broken = false;
		public $parking = false;

		public function __construct($name, $maxSpeed) {
			$this->name = $name;
			$this->maxSpeed = $maxSpeed;
		}
		public function airUp() {
			$this->status = "Взлёт";
			$this->fly = true;
			echo "Самолёт {$this->name}. Статус: {$this->status}.<br>";
			echo "<br>";
		}
		public function airDown() {
			$this->status = "Посадка";
			$this->fly = false;
			echo "Самолёт {$this->name}. Статус: {$this->status}.<br>";
			echo "<br>";
		}
		public function Fly() {
			if ($this->fly == true) {
				echo "Самолёт {$this->name} сейчас находится в воздухе.<br>";
			} elseif ($this->fly == false) {
				echo "Самолёт {$this->name} сейчас находится на земле.<br>";
			}
			echo "<br>";
 		}
		public function PlaneInfo() {
			echo "Название: {$this->name},<br>максимальная скорость: {$this->maxSpeed}.<br>";
			echo "<br>";
		}
	}

	class MIG extends Planes {
		public function Attack() {
			$this->status = "Атака";
			echo "Самалёт {$this->name}. Статус: {$this->status}.<br>";
			echo "<br>";
		}
	}

	class TU_154 extends Planes {
		
	}

	class airport {
		public $places;
		public $planes = array();

		public function __construct($places) {
			$this->places = $places;
		}

		// AcceptPlane() - метод добавления самолёта в аэропорт.
		public function AcceptPlane($plane) {
			if (count ($this->planes) < $this->places) {
				$plane->airDown();
				$this->planes[] = $plane;
				echo "Самолёт {$plane->name} принят в аэропорт.<br>";
				$plane->status = "В аэропорте";
			} else {
				echo "В аэропорте закончились места.<br>";
			}
			echo "<br>";
		}

		// DeletePlane() - метод освобождения места в аэропорте.

		/* 
		*	Я не понимаю почему после выполнения DeletePlane() перестаёт работать AirportPlanes().
		*	Что я сделал не так?
		*/
		public function DeletePlane($plane) {
			$array = array_search($plane, $this->planes);
			if ($array !== false) {
				$plane->airUp();
				unset($this->planes, $array);
				// array_values($this->planes);
				echo "Самолёт {$plane->name} вылетел из аэропорта.<br>";
			}
			echo "<br>";
		}

		// ParkingPlane() - метод отправляет самолёт на стоянку.
		public function ParkingPlane($plane) {
			if ($plane->parking == true) {
				echo "Самолёт {$plane->name} уже находится на стоянке.<br>";
			} else {
				$plane->parking = true;
				echo "Самолёт {$plane->name} отправлен на стоянку.<br>";
			}
			echo "<br>";
		}
		// ReadyPlane() - метод готовит самолёт к взлёту.
		public function ReadyPlane($plane) {
			if ($plane->parking == false) {
				echo "Самолёт {$plane->name} уже готов к взлёту.<br>";
			} else {
				$plane->parking = false;
				echo "Самолёт {$plane->name} готов к взлёту.<br>";
			}
			echo "<br>";
		}
		// RepairPlane() - метод починки самолёта.
		public function RepairPlane() {
			foreach ($this->planes as $repPlane) {
				if ($repPlane->broken == true) {
					echo "Чиним: {$repPlane->name}.<br>";
					$repPlane->broken = false;
				} else {
					echo "Самолёт {$repPlane->name} не требует починки.<br>";
				}
			}
			echo "<br>";
		}
		// AirportPlanes() - метод выводит название всех самолётов в аэропорте.
		public function AirportPlanes() {
			echo "Самолёты в аэропорте: <br>";
			foreach ($this->planes as $airPlane) {
				echo "{$airPlane->name}<br>";
			}
			echo "<br>";
		}
	}


	// АСОЦИАЦИЯ
	$airport = new airport(3);
	$MIG = new MIG("МИГ",1000);
	$TU_154 = new TU_154("ТУ-154",700);

	// АГРЕГАЦИЯ
	$airport->AcceptPlane($MIG);

	// КОМПОЗИЦИЯ
	$airport->AcceptPlane(new MIG("МИГ-3", 640));
	

	// Методы самолётов
	$MIG->airUp();
	$MIG->airDown();
	$MIG->attack();
	$MIG->Fly();
	$MIG->PlaneInfo();

	// Методы аэропорта

	$airport->AcceptPlane($TU_154);
	$airport->ParkingPlane($TU_154);
	$airport->ReadyPlane($TU_154);
	$airport->RepairPlane();
	$airport->AirportPlanes();
	$airport->DeletePlane($TU_154);
	$TU_154->Fly();
?>
