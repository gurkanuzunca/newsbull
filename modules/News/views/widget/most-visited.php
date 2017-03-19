<?php
if (empty($mostVisited)){
    // En çok okunanalar
    $this->load->model('news/news');
    $mostVisited = $this->news->mostVisited(9);
}
?>
<?php if (! empty($mostVisited)): ?>
    <h2 class="section-title">Çok Okunanlar</h2>
    <?php foreach ($mostVisited as $news): ?>
        <div class="item">
            <div class="image">
                <img src="<?php echo getImage($news->image, 'news/thumb', 480, 300); ?>" alt="<?php echo htmlspecialchars($news->title); ?>">
                <div class="category">
                    <a href="<?php echo clink([$news->category->slug]); ?>" title="<?php echo htmlspecialchars($news->category->title); ?>"><?php echo $news->category->title; ?></a>
                </div>
            </div>
            <div class="detail">
                <a href="<?php echo clink([$news->category->slug, $news->slug]); ?>" title="<?php echo htmlspecialchars($news->title); ?>">
                    <h3><?php echo $news->title; ?></h3>
                    <div class="date">
                        <i class="fa fa-clock-o"></i> <?php echo makeDate($news->publishedAt)->dateWithName(); ?>
                    </div>
                </a>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>