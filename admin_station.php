<div class="list">
    <h1 class="border p-3 text-center my-3">站點管理
        <button class="btn btn-success" onclick="$('.add').show();$('.list,.edit').hide()">新增</button>
    </h1>
    <table class="table table-bordered text-center w-100">
        <tr>
            <td>站點名稱</td>
            <td>行駛時間(分鐘)</td>
            <td>停留時間(分鐘)</td>
            <td>操作</td>
        </tr>
        <?php foreach ($pdo->query("SELECT * FROM `station`") as $row): ?>
            <tr>
                <td><?= $row['name']; ?></td>
                <td><?= $row['minute']; ?></td>
                <td><?= $row['waiting']; ?></td>
                <td>
                    <button class="btn btn-warning" onclick="edit('station',<?= $row['id']; ?>);$('.edit').show();$('.list,.add').hide()">編輯</button>
                    <button class="btn btn-danger" onclick="del('station',<?= $row['id']; ?>)">刪除</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
<div class="add" style="display:none">
    <h1 class="border p-3 my-3 text-center">新增站點</h1>
    <form action="./api/add_station.php" method="post">
        <div class="row w-100">
            <label for="name" class="col-2">站點名稱</label>
            <input type="text" name="name" id="name" class="form-group form-control col-10">
        </div>
        <div class="row w-100">
            <label for="addMinute" class="col-2">行駛時間(分鐘)</label>
            <input type="number" name="minute" id="addMinute" class="form-group form-control col-10" min="0" step="1" required>
        </div>
        <div class="row w-100">
            <label for="addWaiting" class="col-2">停留時間(分鐘)</label>
            <input type="number" name="waiting" id="addWaiting" class="form-group form-control col-10" min="0" step="1" required>
        </div>
        <div class="row w-100">
            <input type="submit" value="新增" class="col-12 btn btn-success my-1">
            <input type="button" value="回上頁" class="col-12 btn btn-secondary my-1" onclick="$('.list').show();$('.edit,.add').hide()">
        </div>
    </form>
</div>
<div class="edit" style="display:none">
    <h1 class="border p-3 my-3 text-center">修改「<span id='title'></span>」</h1>
    <form action="./api/edit_station.php" method="post">
        <div class="row w-100">
            <label for="editMinute" class="col-2">行駛時間(分鐘)</label>
            <input type="number" name="minute" id="editMinute" class="form-group form-control col-10" min="0" step="1" required>
        </div>
        <div class="row w-100">
            <label for="editWaiting" class="col-2">停留時間(分鐘)</label>
            <input type="number" name="waiting" id="editWaiting" class="form-group form-control col-10" min="0" step="1" required>
        </div>
        <div class="row w-100">
            <input type="hidden" name="id" id="editId">
            <input type="submit" value="修改" class="col-12 btn btn-success my-1">
            <input type="button" value="回上頁" class="col-12 btn btn-secondary my-1" onclick="$('.list').show();$('.edit,.add').hide()">
        </div>
    </form>
</div>