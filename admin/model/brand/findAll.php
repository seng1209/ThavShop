<table class="table">
    <thead>
        <tr style="text-align: center;">
            <th scope="col">ID</th>
            <th scope="col">Image</th>
            <th scope="col">Category</th>
            <th scope="col">Description</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $sql = "SELECT * FROM brands";
            $result = $conn->query($sql);
            if($result->num_rows >0){
                while($row = $result->fetch_assoc()){
        ?>
            <tr>
                <th scope="row"><?=$row['brand_id']?></th>
                <td><img src="../../uploads/brand_image/<?=$row['image']?>" alt="<?=$row['image']?>" width="200px" /></td>
                <td><?=$row['brand']?></td>
                <td><?=$row['description']?></td>
                <td style="text-align: center;">
                <a href="update.php?id=<?=$row['brand_id']?>" class="btn btn-warning m-1">Update</a>
                <a href="delete.php?id=<?=$row['brand_id']?>" class="btn btn-danger m-1">Delete</a>
                </td>
            </tr>
        <?php
                }
            }
        ?>
    </tbody>
</table>