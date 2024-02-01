<div class="header-content">
    <span>Отзывы</span>
</div>
<div class="list">
    <table class="list-items table table-hover table-striped">
        <thead class="list-header">
            <tr>
                <th>Дата</th>
                <th>Статус</th>
                <th>Рейтинг</th>
                <th>Отзыв</th>
                <th>Комментарий</th>
            </tr>
        </thead>
        <tbody>

        @foreach($post->reviews as $review)
            <tr class="list-item">
                <td>{{ $review->created_at === '' ?? $review->created_at->format('Y-m-d') }}</td>
                <td>{{ postReviews()->getStatus($review->status) }}</td>
                <td>{{ $review->rating }}</td>
                <td>{{ $review->comment }}</td>
                <td>{{ $review->response }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
