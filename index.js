function scroll(){
    let lastScrollTop = 0;
    let header = document.getElementById("header");
    window.addEventListener("scroll", function(){     
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        if(scrollTop > lastScrollTop){
            if (this.window.innerWidth >=920){
                header.style.top = "-100px";
            }
            else{
                header.style.top = "-450px";
            }
            
        }
        else{
            header.style.top = "0";
        }
        if(scrollTop=="0"){
            header.style.width = "99.2%";
        }
        else{
            if (this.window.innerWidth >=920){
                header.style.width ="40%";
            }
        }
        if(scrollTop<0){
            scrollTop = 0;
        }
        lastScrollTop = scrollTop;
        }
    )
}

function appear(){
    window.addEventListener("scroll",function(){
        const observer = new IntersectionObserver((entries) =>{
            entries.forEach((entry)=> {
                if (entry.isIntersecting){
                    entry.target.classList.add("show");
                }
                else{
                    entry.target.classList.remove("show");
                }
            });
        });
        const hidden = document.querySelectorAll(".hidden")
        hidden.forEach((el) => observer.observe(el));
    });
}

function startfadein(){
    const start = document.getElementById("start");
    start.style.opacity="1";
}

function clearBlog(){
   const confirmation = confirm("Are you sure you want to clear?");
    if (confirmation){
        console.log("clear");
        document.getElementById("addBlogForm").reset();
    }
    else{
        return false;
    }
    
}


function preventEmptyBlog(event){
    event.preventDefault();

    const titleInput = document.getElementById("blog-name");
    const postInput = document.getElementById("blog-text");

    const titleInputTrim = titleInput.value.trim();
    const postInputTrim = postInput.value.trim();

    if(titleInputTrim === ''){
        titleInput.classList.add("missing-field");
        return;
    }
    else{
        titleInput.classList.remove("missing-field");
    }

    if(postInputTrim === ''){
        postInput.classList.add("missing-field");
        return;
    }
    else{
        postInput.classList.remove("missing-field");
    }

    const b = document.querySelector("#addBlogForm");
    b.submit();
}

function changeX(x){
    x.classList.toggle("change");
    const a = document.querySelector(".navbar");
    a.classList.toggle("shown");
}

