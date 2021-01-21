<div class="row pt-4">
<div class="card mx-auto col-6 record-preview" data-href=<?php echo "/record/".$record['id'];?>>
    <div class="card-body">
        <h4 class="card-title"><?php echo $record['title']; ?></h4>
        <h6 class="card-subtitle mb-2 text-muted"><?php
        echo $record['date']."  ";
        $author_id = $record['author'];
        $author = Record::get_author($author_id);
        echo "<a href='/user/$author_id'>$author</a>"
        ?></h6>
        <div class="card-text"><?php echo substr($record['text'],0,100); ?></div>
    </div>
</div>
</div>