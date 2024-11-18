<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    <title>Document</title>
</head>

<body>
    <?php
    include_once('EmployeeManagement.php');
    // session_start();
    ?>
    <form method="post">
        <label for="fname">First Name:</label><br>
        <input type="text" id="fname" name="fname"><br>
        <label for="lname">Last Name:</label><br>
        <input type="text" id="lname" name="lname"><br>
        <label for="dob">Date Of Birth:</label><br>
        <input type="text" id="dob" name="dob"><br>
        <label for="address">Address:</label><br>
        <input type="text" id="address" name="address"><br>

        <label for="salary">Salary :</label><br>
        <input type="text" id="salary" name="salary"><br>
        <input type="submit" value="Add Employee" name="add"><br>
        <input type="submit" value="Display Employee" name="display"><br>
    </form>
    <form method="post">
        <label for="contractor-fname">First Name:</label><br>
        <input type="text" id="contractor-fname" name="contractor-fname"><br>
        <label for="contractor-lname">Last Name:</label><br>
        <input type="text" id="contractor-lname" name="contractor-lname"><br>
        <label for="contractor-dob">Date Of Birth:</label><br>
        <input type="text" id="contractor-dob" name="contractor-dob"><br>
        <label for="contractor-address">Address:</label><br>
        <input type="text" id="contractor-address" name="contractor-address"><br>
        <label for="contract-period">Contract Period :</label><br>
        <input type="text" id="contract-period" name="contract-period"><br>
        <label for="hourly-rate">Hourly Rate :</label><br>
        <input type="text" id="hourly-rate" name="hourly-rate"><br>
        <input type="submit" value="Add Contractor" name="contractor-add"><br>
        <input type="submit" value="Display Contractor" name="contractor-display"><br>
    </form>
    <form method="post">
        <label for="manager-fname">First Name:</label><br>
        <input type="text" id="manager-fname" name="manager-fname"><br>
        <label for="manager-lname">Last Name:</label><br>
        <input type="text" id="manager-lname" name="manager-lname"><br>
        <label for="manager-dob">Date Of Birth:</label><br>
        <input type="text" id="manager-dob" name="manager-dob"><br>
        <label for="manager-address">Address:</label><br>
        <input type="text" id="manager-address" name="manager-address"><br>
        <label for="manager-salary">Salary :</label><br>
        <input type="text" id="manager-salary" name="manager-salary"><br>
        <label for="team_members">Team Members:</label><br>
        <p>
            <?php
            $tmp = EmployeeManager::loadFromFile('selected-member.json');
            if (!empty($tmp)) {
                foreach ($tmp as $i) {
            ?>
                    <span> <?php echo $i->getFirstName() . " " . $i->getLastName(); ?>
                    </span>
            <?php
                }
            }
            ?>
        </p>
        <select name="team-member" id="team-member">
            <?php
            // Load danh sách nhân viên để chọn
            $newEmployeeManager = new EmployeeManager();
            $newEmployeeManager->employees = EmployeeManager::loadFromFile('employee-list.json');
            foreach ($newEmployeeManager->employees as $employee):
            ?>
                <option value="<?php echo $employee->getID(); ?>">
                    <?php echo $employee->getFirstName() . " " . $employee->getLastName(); ?>
                </option>
            <?php endforeach; ?>
        </select><br>
        <input type="submit" name="add-member" value="Add Member"><br><br>
        <input type="submit" value="Add Manager" name="manager-add"><br>
        <input type="submit" value="Display Manager" name="manager-display"><br>

    </form>
</body>

</html>