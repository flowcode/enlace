<h1>Saved Demos</h1>
<a href="/demo/create">Create demo</a>
<? foreach ($viewData["demos"] as $demo): ?>
    <div class="demo">
        <div>
            <label>id:</label>
            <span><? echo $demo->getId() ?></span>
        </div>
        <div>
            <label>name:</label>
            <span><? echo $demo->getName() ?></span>
        </div>
    </div>
<? endforeach; ?>
