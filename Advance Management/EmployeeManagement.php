<?php

class Person
{
    protected $id;
    protected $firstName;
    protected $lastName;
    protected $dateOfBirth;
    protected $address;

    public function getID()
    {
        return $this->id;
    }
    public function getFirstName()
    {
        return $this->firstName;
    }
    public function getLastName()
    {
        return $this->lastName;
    }
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }
    public function getAddress()
    {
        return $this->address;
    }

    public function setID($id)
    {
        $this->id = $id;
    }
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }
    public function setAddress($address)
    {
        $this->address = $address;
    }
}

class Contractor extends Person
{
    public $contractPeriod;
    private $hourlyRate;
    public $jobPosition;

    public function getHourlyRate()
    {
        return $this->hourlyRate;
    }

    public function setHourlyRate($hourlyRate)
    {
        $this->hourlyRate = $hourlyRate;
    }

    public function toArray()
    {
        return [
            'id' => $this->getID(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'dateOfBirth' => $this->getDateOfBirth(),
            'address' => $this->getAddress(),
            'jobPosition' => $this->jobPosition,
            'contractPeriod' => $this->contractPeriod,
            'hourlyRate' => $this->getHourlyRate(),
            'salary' => $this->getHourlyRate()
        ];
    }

    public static function fromArray($data)
    {
        $contractor = new Contractor();
        $contractor->setID($data['id']);
        $contractor->setFirstName($data['firstName']);
        $contractor->setLastName($data['lastName']);
        $contractor->setDateOfBirth($data['dateOfBirth']);
        $contractor->setAddress($data['address']);
        $contractor->jobPosition = $data['jobPosition'];
        $contractor->contractPeriod = $data['contractPeriod'];
        $contractor->setHourlyRate($data['hourlyRate']);
        return $contractor;
    }
}

class Employee extends Person
{
    public $jobPosition;
    protected $salary;
    public function getSalary()
    {
        return $this->salary;
    }
    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    public function toArray()
    {
        return [
            'id' => $this->getID(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'dateOfBirth' => $this->getDateOfBirth(),
            'address' => $this->getAddress(),
            'jobPosition' => $this->jobPosition,
            'salary' => $this->getSalary()
        ];
    }

    public static function fromArray($data)
    {
        $employee = new Employee();
        $employee->setID($data['id']);
        $employee->setFirstName($data['firstName']);
        $employee->setLastName($data['lastName']);
        $employee->setDateOfBirth($data['dateOfBirth']);
        $employee->setAddress($data['address']);
        $employee->jobPosition = $data['jobPosition'];
        $employee->setSalary($data['salary']);
        return $employee;
    }
}

class Manager extends Employee
{
    private $team = [];
    public function displayTeam()
    {
        return $this->team;
    }
    public function setTeam($team)
    {
        $this->team = $team;
    }

    public static function addTeamMember($member)
    {
        $tmp = EmployeeManager::loadFromFile('selected-member.json');
        $tmp[] = $member;
        EmployeeManager::saveToFile($tmp, 'selected-member.json');
        // return $tmp;
    }

    public function removeTeamMember($id)
    {
        unset($this->team[$id]);
    }

    public function toArray()
    {
        $baseArray = parent::toArray();

        $teamArray = [];
        foreach ($this->team as $member) {
            $teamArray[] = $member->toArray();
        }

        $baseArray['team'] = $teamArray;

        return $baseArray;
    }

    public static function fromArray($data)
    {
        $manager = new Manager();
        $manager->setID($data['id']);
        $manager->setFirstName($data['firstName']);
        $manager->setLastName($data['lastName']);
        $manager->setDateOfBirth($data['dateOfBirth']);
        $manager->setAddress($data['address']);
        $manager->jobPosition = $data['jobPosition'];
        $manager->setSalary($data['salary']);

        if (isset($data['team'])) {
            $team = [];
            foreach ($data['team'] as $memberData) {
                $team[] = Employee::fromArray($memberData);
            }
            $manager->setTeam($team);
        }

        return $manager;
    }
}

class EmployeeManager
{
    public $employees = [];
    // public $readFromJSON = [];
    public function addEmployee($employee)
    {
        // $this->loadFromFile();
        $this->employees = $this->loadFromFile('employee-list.json');
        array_push($this->employees, $employee);
        $this->saveToFile($this->employees, 'employee-list.json');
    }
    public function displayEmployeeList($position)
    {
        $this->employees = $this->loadFromFile('employee-list.json'); ?>
        <form method="get">
            <?php
            foreach ($this->employees as $employee):
                if ($employee->jobPosition == $position):
            ?>
                    <label>
                        <?php echo "Full Name: " . $employee->getFirstName() . " " . $employee->getLastName() ?>
                    </label>
                    <button type="submit" name="detail" value="<?php echo $employee->getID() ?>">Detail</button>
            <?php
                endif;
            endforeach;
            ?>
        </form>
    <?php
    }

    public static function findMaxID($array)
    {
        $maxID = 0;
        foreach ($array as $item) {
            if ($item->getID() > $maxID) {
                $maxID = $item->getID();
            }
        }

        return $maxID;
    }

    public function getEmployeeDetails($id)
    {
        $this->employees = $this->loadFromFile('employee-list.json'); ?>
        <div>
            <?php
            foreach ($this->employees as $employee):
                if ($employee->getID() == $id):
            ?>
                    <p>
                        <?php echo "Full Name: " . $employee->getFirstName() . " " . $employee->getLastName() ?>
                    </p>
                    <p>
                    </p>
                    <p>
                        <?php echo "Date Of Birth: " . $employee->getDateOfBirth() ?>
                    </p>
                    <p>
                        <?php echo "Address: " . $employee->getAddress() ?>
                    </p>
                    <p>
                        <?php echo "Job Position: " . $employee->jobPosition ?>
                    </p>
                    <p>
                        <?php echo "Salary: " . $employee->getSalary() ?>
                    </p>
            <?php
                endif;
            endforeach;
            ?>
        </div>
<?php
    }

    public static function saveToFile($input, $filename)
    {
        $data = array_map(function ($employee) {
            return $employee->toArray();
        }, $input);
        file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
    }

    public static function loadFromFile($filename)
    {
        $readFromJSON = json_decode(file_get_contents($filename), true);
        if (!empty($readFromJSON)) :
            foreach ($readFromJSON as $item) {
                if ($item['jobPosition'] == "Manager"):
                    $output[] = Manager::fromArray($item);
                elseif ($item['jobPosition'] == "Contractor"):
                    $output[] = Contractor::fromArray($item);
                elseif ($item['jobPosition'] == "Employee"):
                    $output[] = Employee::fromArray($item);
                endif;
            }
            return $output;
        else:
            return [];
        endif;
    }
}

function findKey($haystack, $needle)
{
    $key = -1;
    foreach ($haystack as $index => $item) {
        if ($item->getID() == $needle) {
            $key = $index;
        }
    }
    return $key;
}

$newEmployeeManager = new EmployeeManager();
if ($_SERVER["REQUEST_METHOD"] == "POST") :
    if (isset($_POST["add"])) :
        $newEmployee = new Employee;
        $employees = EmployeeManager::loadFromFile('employee-list.json');
        $newEmployee->setID(EmployeeManager::findMaxID($employees) + 1);
        $newEmployee->setFirstName(($_POST['fname']));
        $newEmployee->setLastName(($_POST['lname']));
        $newEmployee->setDateOfBirth(($_POST['dob']));
        $newEmployee->setAddress(($_POST['address']));
        $newEmployee->jobPosition = "Employee";
        $newEmployee->setSalary(($_POST['salary']));
        $newEmployeeManager->addEmployee($newEmployee);
    elseif (isset($_POST["display"])):
        $newEmployeeManager->displayEmployeeList("Employee");
    elseif (isset($_POST["contractor-add"])):
        $newContractor = new Contractor;
        $employees = EmployeeManager::loadFromFile('employee-list.json');
        $newContractor->setID(EmployeeManager::findMaxID($employees) + 1);
        $newContractor->setFirstName(($_POST['contractor-fname']));
        $newContractor->setLastName(($_POST['contractor-lname']));
        $newContractor->setDateOfBirth(($_POST['contractor-dob']));
        $newContractor->setAddress(($_POST['contractor-address']));
        $newContractor->setHourlyRate($_POST['hourly-rate']);
        $newContractor->jobPosition = "Contractor";
        $newEmployeeManager->addEmployee($newContractor);
    elseif (isset($_POST["contractor-display"])):
        $newEmployeeManager->displayEmployeeList("Contractor");
    elseif (isset($_POST["manager-add"])):
        $newManager = new Manager;
        $employees = EmployeeManager::loadFromFile('employee-list.json');
        $newManager->setID(EmployeeManager::findMaxID($employees) + 1);
        $newManager->setFirstName(($_POST['manager-fname']));
        $newManager->setLastName(($_POST['manager-lname']));
        $newManager->setDateOfBirth(($_POST['manager-dob']));
        $newManager->setAddress(($_POST['manager-address']));
        $newManager->jobPosition = "Manager";
        $newManager->setSalary(($_POST['manager-salary']));
        $tmp = EmployeeManager::loadFromFile('selected-member.json');
        $newManager->setTeam($tmp);
        $newEmployeeManager->addEmployee($newManager);
        EmployeeManager::saveToFile([], 'selected-member.json');
    elseif (isset($_POST["manager-display"])):
        $newEmployeeManager->displayEmployeeList("Manager");
    endif;
    if (isset($_POST["add-member"])):
        $employees = EmployeeManager::loadFromFile('employee-list.json');
        $key = findKey($employees, $_POST['team-member']);
        Manager::addTeamMember($employees[$key]);
    endif;
elseif (($_SERVER["REQUEST_METHOD"] == "GET")):
    if (isset($_GET["detail"])) :
        $id = $_GET["detail"];
        $newEmployeeManager->getEmployeeDetails($id);
    endif;
endif;
?>