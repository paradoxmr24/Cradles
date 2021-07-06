show = (el) => {
    if(el.value == "CS") 
        document.getElementById("cs").classList.remove("d-none");
    else 
        document.getElementById("cs").classList.add("d-none");
    
}

click = () => {
    console.log("AAAA");
}
checkLimit = (el,limit) => {
    if(el.value.length > limit) 
        document.getElementById("submit").setAttributeNode(document.createAttribute("disabled"));
    else
        document.getElementById("submit").removeAttribute("disabled");
}