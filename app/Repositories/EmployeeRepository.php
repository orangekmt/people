<?php

namespace App\Repositories;

use App\Employee;

class EmployeeRepository
{

    protected $employee;

    public function __construct(Employee $employee)
	{
		$this->employee = $employee;
	}

	private function save(Employee $employee, Array $inputs)
	{
		$employee->employee_name = $inputs['employee_name'];
		$employee->manager_id = $inputs['manager_id'];	

		$employee->save();
	}

	public function getPaginate($n)
	{
		return $this->employee->paginate($n);
	}

	public function store(Array $inputs)
	{
		$employee = new $this->employee;		

		$this->save($employee, $inputs);

		return $employee;
	}

	public function getById($id)
	{
		return $this->employee->findOrFail($id);
	}

	public function update($id, Array $inputs)
	{
		$this->save($this->getById($id), $inputs);
	}

	public function destroy($id)
	{
		$this->getById($id)->delete();
	}

}