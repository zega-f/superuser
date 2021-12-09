

@if (@$id_url==null)
    
@else
   
    <div class="embed-responsive embed-responsive-16by9">
        <iframe src="https://www.youtube.com/embed/{{@$id_url}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
@endif
