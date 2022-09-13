<div id="confirmDelete" class="modal fade">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Удалить запись?</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Вы собираетесь удалить запись</p>
                <div class="items"></div>
            </div>
            <div class="modal-footer">
                <form action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button class="btn btn-danger" type="submit">Удалить</button>
                </form>
            </div>
        </div>
    </div>
</div>
