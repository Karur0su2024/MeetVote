<div class="card text-start">
    <div class="card-header py-2">
        <h2>Comments</h2>
    </div>
    <div class="card-body p-0">
        <div class="list-group">

            @foreach ($comments as $comment)
                <x-poll.show.comment-card :comment="$comment" />
            @endforeach
        </div>
        <div class="p-3">
            <h3>Add new comments</h3>
            <form wire:submit.prevent='addComment' wire:key='{{ now() }}'>
                <x-input id="username" model="username" type="text" label="Your name" />
                <x-textbox id="content" model="content" label="Your message" mandatory="true"/>
                <button type="submit" class="btn btn-primary">Add comment</button>
            </form>
        </h2>

        </div>


    </div>
</div>