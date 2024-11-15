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
            'id' => $this->id,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'dateOfBirth' => $this->dateOfBirth,
            'address' => $this->address,
            'jobPosition' => $this->jobPosition,
            'salary' => $this->salary
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

class EmployeeManager
{
    public $employees = [];
    public $readFromJSON = [];
    public function addEmployee($employee)
    {
        $tmp = $employee->toArray();
        array_push($this->employees, $tmp);
        $this->saveToFile();
    }
    public function displayEmployeeList()
    {
        $this->loadFromFile(); ?>
        <form method="get">
            <?php
            foreach ($this->employees as $employee): ?>
                <label>
                    <?php echo "Full Name: " . $employee->getFirstName() . " " . $employee->getLastName() ?>
                </label>
                <button type="submit" name="detail" value="<?php echo $employee->getID() ?>">Detail</button>
            <?php
            endforeach;
            ?>
        </form>
    <?php
    }

    public function getEmployeeDetails($id)
    {
        $this->loadFromFile(); ?>
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

    public function saveToFile()
    {
        file_put_contents('employee-list.json', json_encode($this->employees, JSON_PRETTY_PRINT));
    }

    public function loadFromFile()
    {
        $this->readFromJSON = json_decode(file_get_contents('employee-list.json'), true);
        foreach ($this->readFromJSON as $item) {
            $this->employees[] = Employee::fromArray($item);
        }
    }
}

$newEmployeeManager = new EmployeeManager();
?>
<div>
    <form method="post">
        <label for="fname">First Name:</label><br>
        <input type="text" id="fname" name="fname"><br>
        <label for="lname">Last Name:</label><br>
        <input type="text" id="lname" name="lname"><br>
        <label for="dob">Date Of Birth:</label><br>
        <input type="text" id="dob" name="dob"><br>
        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address"><br>
        <label for="position">Job Position :</label><br>
        <input type="text" id="position" name="position"><br>
        <label for="salary">Salary :</label><br>
        <input type="text" id="salary" name="salary"><br>
        <input type="submit" value="Add Employee" name="add"><br>
        <input type="submit" value="Display Employee" name="display"><br>
    </form>

</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") :
    if (isset($_POST["add"])) :
        $newEmployee = new Employee;
        $newEmployee->setID(count($newEmployeeManager->employees) + 1);
        $newEmployee->setFirstName(($_POST['fname']));
        $newEmployee->setLastName(($_POST['lname']));
        $newEmployee->setDateOfBirth(($_POST['dob']));
        $newEmployee->setAddress(($_POST['address']));
        $newEmployee->jobPosition = $_POST['position'];
        $newEmployee->setSalary(($_POST['salary']));
        $newEmployeeManager->addEmployee($newEmployee);
    elseif (isset($_POST["display"])):
        $newEmployeeManager->displayEmployeeList();
    endif;
elseif (($_SERVER["REQUEST_METHOD"] == "GET")):
    if (isset($_GET["detail"])) :
        $id = $_GET["detail"];
        $newEmployeeManager->getEmployeeDetails($id);
    endif;
endif;
?>