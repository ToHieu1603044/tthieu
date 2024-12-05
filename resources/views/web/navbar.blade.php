@section('navbar')
<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
       <li class="active dropdown">
          <a href="" class="dropdown-toggle" data-toggle="dropdown">Home</a>
          {{-- <div class="dropdown-menu">
             <ul class="mega-menu-links">
                <li><a href="index.html">home</a></li>
                <li><a href="home2.html">home2</a></li>
                <li><a href="home3.html">home3</a></li>
                <li><a href="productlitst.html">Productlitst</a></li>
                <li><a href="productgird.html">Productgird</a></li>
                <li><a href="details.html">Details</a></li>
                <li><a href="cart.html">Cart</a></li>
                <li><a href="checkout.html">CheckOut</a></li>
                <li><a href="checkout2.html">CheckOut2</a></li>
                <li><a href="contact.html">contact</a></li>
             </ul>
          </div> --}}
       </li>
       
       <li class="dropdown">
         <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fashion</a>
         <div class="dropdown-menu mega-menu">
             <div class="row">
                 @foreach ($categories as $parent)
                     <div class="col-md-6 col-sm-6">
                         <ul class="mega-menu-links">
                             <li><h5 class="text-danger">{{ $parent->name }}</h5></li>
                             
                           
                             @foreach ($parent->children as $child)

                                 <li><a href="{{ route('get-pro-by-cate',$parent->slug) }}">{{ $child->name }}</a></li>
                             @endforeach
                         </ul>
                     </div>
                 @endforeach
             </div>
         </div>
     </li>
       <li><a href="productgird.html">gift</a></li>
       <li><a href="productgird.html">kids</a></li>
       <li><a href="productgird.html">blog</a></li>
       <li><a href="productgird.html">jewelry</a></li>
       <li><a href="contact.html">contact us</a></li>
    </ul>
 </div>
@endsection