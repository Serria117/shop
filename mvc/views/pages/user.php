<h2>User</h2>
<table class='tbl table-stripped'>
    <tr>
        <td>user Name</td>
        <td>user Email</td>
        <td>user Type</td>
    </tr>
    <?php
    foreach($data['userList'] as $user){
        echo "
        <tr>
            <td>{$user['userName']}</td>
            <td>{$user['userEmail']}</td>
            <td>{$user['userType']}</td>
        </tr>
        ";
    }
    echo "</table>";
    ?>
</table>
