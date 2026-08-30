const productsGrid=document.getElementById("productsGrid");
const cartCount=document.getElementById("cartCount");
const cartItems=document.getElementById("cartItems");
const cartTotal=document.getElementById("cartTotal");
let products=[], currentCart=[], activeCategory="all", pendingProductId=null;

const formatPrice=p=>"Rs. "+Number(p).toLocaleString("en-PK");
function escapeHtml(v){const d=document.createElement("div");d.textContent=v??"";return d.innerHTML}
function showToast(message){const t=document.getElementById("toast");if(!t)return;t.textContent=message;t.classList.add("show");clearTimeout(window.toastTimer);window.toastTimer=setTimeout(()=>t.classList.remove("show"),2600)}

async function api(url, options={}) {
  const r=await fetch(url,options);
  const data=await r.json().catch(()=>({success:false,message:"Server error."}));
  if(r.status===401){ pendingProductId=options.productId??pendingProductId; openAuth(); }
  return data;
}
async function loadProducts(){
  const data=await api("api/products.php"); products=data.products||[]; renderProducts();
}
function filteredProducts(){
 return products.filter(p=>{
   const cat=(p.category||"").toLowerCase(), type=(p.type||"").toLowerCase();
   return activeCategory==="all"||cat===activeCategory||type===activeCategory;
 });
}
function stockBadge(p){
 const s=Number(p.stock_quantity||0);
 if(s<=0)return `<span class="stock-badge out-of-stock">Out of Stock</span>`;
 if(s<=5)return `<span class="stock-badge low-stock">Only ${s} left</span>`;
 return `<span class="stock-badge in-stock">In Stock</span>`;
}
function renderProducts(){
 if(!productsGrid)return;
 const list=filteredProducts();
 productsGrid.innerHTML=list.length?list.map((p,i)=>{
 const outOfStock=Number(p.stock_quantity||0)<=0;
 return `<article class="product-card" style="animation-delay:${i*.06}s">
 <div class="product-image"><img src="${escapeHtml(p.image)}" alt="${escapeHtml(p.name)}" loading="lazy">${stockBadge(p)}</div>
 <div class="product-info"><span class="product-category">${escapeHtml(p.category)}</span><h3>${escapeHtml(p.name)}</h3>
 <p class="product-price">${formatPrice(p.price)}</p><div class="product-actions">
 <button onclick="openProduct(${p.id})">View</button><button class="add-btn" ${outOfStock?"disabled":""} onclick="addToCart(${p.id})">${outOfStock?"Out of Stock":"Add to Cart"}</button></div></div></article>`;
 }).join("")
 : `<p style="grid-column:1/-1;text-align:center;color:#94a3b8;padding:50px;">No watches found.</p>`;
}
document.querySelectorAll(".filter-btn").forEach(b=>b.addEventListener("click",()=>{activeCategory=b.dataset.category;document.querySelectorAll(".filter-btn").forEach(x=>x.classList.remove("active"));b.classList.add("active");renderProducts()}));

async function loadCart(){
 if(!window.KASHI_AUTH)return;
 const data=await api("api/cart.php"); if(data.success){currentCart=data.cart.items||[];renderCart(data.cart)}
}
function renderCart(cart={items:currentCart,total:0,count:0}){
 currentCart=cart.items||[]; if(cartCount)cartCount.textContent=cart.count||0;
 if(!cartItems||!cartTotal)return;
 cartItems.innerHTML=currentCart.length?currentCart.map(i=>`<div class="cart-item"><img src="${escapeHtml(i.image)}" alt="${escapeHtml(i.name)}"><div><h4>${escapeHtml(i.name)}</h4><p>${formatPrice(i.price)}</p><div class="qty-controls"><button onclick="changeQuantity(${i.product_id},${i.quantity-1})">-</button><span>${i.quantity}</span><button onclick="changeQuantity(${i.product_id},${i.quantity+1})">+</button></div></div><button class="remove-item" onclick="removeFromCart(${i.product_id})">Remove</button></div>`).join(""):`<p class="empty-cart">Your cart is empty.</p>`;
 cartTotal.textContent=formatPrice(cart.total||0);
}
async function addToCart(id){
 if(!window.KASHI_AUTH){pendingProductId=id;openAuth();return}
 const data=await api("api/cart.php",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({action:"add",product_id:id})});
 if(data.success){renderCart(data.cart);showToast("Product added to cart.");openCart()}else showToast(data.message);
}
async function changeQuantity(id,quantity){
 const data=await api("api/cart.php",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({action:"update",product_id:id,quantity})});
 if(data.success)renderCart(data.cart);else showToast(data.message);
}
async function removeFromCart(id){
 const data=await api("api/cart.php",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({action:"remove",product_id:id})});
 if(data.success){renderCart(data.cart);showToast("Product removed.");}
}
const cartSidebar=document.getElementById("cartSidebar"),cartOverlay=document.getElementById("cartOverlay");
function openCart(){if(!window.KASHI_AUTH){openAuth();return}cartSidebar?.classList.add("active");cartOverlay?.classList.add("active");document.body.classList.add("no-scroll");}
function closeCart(){cartSidebar?.classList.remove("active");cartOverlay?.classList.remove("active");document.body.classList.remove("no-scroll")}
document.getElementById("cartBtn")?.addEventListener("click",openCart);document.getElementById("closeCart")?.addEventListener("click",closeCart);cartOverlay?.addEventListener("click",closeCart);

const productModal=document.getElementById("productModal"),modalContent=document.getElementById("modalContent");
window.openProduct=id=>{const p=products.find(x=>Number(x.id)===Number(id));if(!p)return;const outOfStock=Number(p.stock_quantity||0)<=0;modalContent.innerHTML=`<div class="modal-product"><img src="${escapeHtml(p.image)}" alt=""><div class="modal-info"><span class="product-category">${escapeHtml(p.category)}</span><h2>${escapeHtml(p.name)}</h2><div class="modal-price">${formatPrice(p.price)}</div>${stockBadge(p)}<p>${escapeHtml(p.description)}</p><button class="modal-add" ${outOfStock?"disabled":""} onclick="addToCart(${p.id});closeProductModal()">${outOfStock?"Out of Stock":"Add to Cart"}</button></div></div>`;productModal.classList.add("active");document.body.classList.add("no-scroll")}
window.closeProductModal=()=>{productModal?.classList.remove("active");document.body.classList.remove("no-scroll")}
document.getElementById("modalClose")?.addEventListener("click",closeProductModal);productModal?.addEventListener("click",e=>{if(e.target===productModal)closeProductModal()});

const authOverlay=document.getElementById("authOverlay"),loginContent=document.getElementById("loginContent"),registerContent=document.getElementById("registerContent");
function openAuth(){authOverlay?.classList.add("active");document.body.classList.add("no-scroll");loginContent?.classList.remove("hidden");registerContent?.classList.add("hidden")}
function closeAuth(){authOverlay?.classList.remove("active");document.body.classList.remove("no-scroll")}
document.getElementById("openAuthBtn")?.addEventListener("click",openAuth);document.getElementById("authClose")?.addEventListener("click",closeAuth);
document.getElementById("showRegister")?.addEventListener("click",e=>{e.preventDefault();loginContent.classList.add("hidden");registerContent.classList.remove("hidden")});
document.getElementById("showLogin")?.addEventListener("click",e=>{e.preventDefault();registerContent.classList.add("hidden");loginContent.classList.remove("hidden")});
authOverlay?.addEventListener("click",e=>{if(e.target===authOverlay)closeAuth()});
async function submitAuth(form,url){
 const data=await api(url,{method:"POST",body:new FormData(form)});
 if(data.success){window.KASHI_AUTH=true;showToast(data.message);setTimeout(()=>location.reload(),500)}else showToast(data.message)
}
document.getElementById("loginForm")?.addEventListener("submit",e=>{e.preventDefault();submitAuth(e.currentTarget,"login.php")});
document.getElementById("registerForm")?.addEventListener("submit",e=>{e.preventDefault();submitAuth(e.currentTarget,"signup.php")});

document.getElementById("checkoutBtn")?.addEventListener("click",async()=>{if(!currentCart.length){showToast("Your cart is empty.");return}const data=await api("api/checkout.php",{method:"POST"});showToast(data.message);if(data.success){closeCart();loadCart();loadProducts()}});
document.getElementById("newsletterForm")?.addEventListener("submit",async e=>{e.preventDefault();const data=await api("api/newsletter.php",{method:"POST",body:new FormData(e.currentTarget)});showToast(data.message);if(data.success)e.currentTarget.reset()});
document.getElementById("complaintForm")?.addEventListener("submit",async e=>{e.preventDefault();const data=await api("api/complaint.php",{method:"POST",body:new FormData(e.currentTarget)});showToast(data.message);if(data.success)e.currentTarget.reset()});

const menuBtn=document.getElementById("menuBtn"),navLinks=document.getElementById("navLinks");
menuBtn?.addEventListener("click",()=>navLinks?.classList.toggle("active"));
const navbar=document.getElementById("navbar"),backTop=document.getElementById("backTop");
window.addEventListener("scroll",()=>{navbar?.classList.toggle("scrolled",window.scrollY>50);backTop?.classList.toggle("show",window.scrollY>600)});
backTop?.addEventListener("click",()=>window.scrollTo({top:0,behavior:"smooth"}));
document.addEventListener("keydown",e=>{if(e.key==="Escape"){closeCart();closeProductModal();closeAuth()}});
const observer=new IntersectionObserver(es=>es.forEach(e=>{if(e.isIntersecting){e.target.classList.add("visible");observer.unobserve(e.target)}}),{threshold:.12});
document.querySelectorAll(".reveal").forEach(e=>observer.observe(e));
loadProducts();loadCart();
