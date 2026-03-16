document.addEventListener("DOMContentLoaded", function () {
    const nonTaxCheckYes = document.getElementById('nonTaxCheckYes');
    const nonTaxCheckNo = document.getElementById('nonTaxCheckNo');
    const additionalTax = document.getElementById('additionalTax');
    // const nonTax2checkYes = document.getElementById('nonTax2checkYes');
    // const nonTax2checkNo = document.getElementById('nonTax2checkNo');


    nonTaxCheckNo.addEventListener('change', function () {
        if (this.checked) {
            additionalTax.style.display = 'none';
            // nonTax2checkYes.checked = false;
            // nonTax2checkNo.checked = false;
        }
    });

    nonTaxCheckYes.addEventListener('change', function () {
        if (this.checked) {
            additionalTax.style.display = 'block'; 
        }
    });
   
});

document.addEventListener("DOMContentLoaded", function () {
    const nonTax2checkYes = document.getElementById('nonTax2checkYes');
    const nonTax2checkNo = document.getElementById('nonTax2checkNo');
    const btnAddChildren = document.getElementById('btnAddChildren');
    // const nonTax2checkYes = document.getElementById('nonTax2checkYes');
    // const nonTax2checkNo = document.getElementById('nonTax2checkNo');


    nonTax2checkNo.addEventListener('change', function () {
        if (this.checked) {
            btnAddChildren.style.display = 'none';
            // nonTax2checkYes.checked = false;
            // nonTax2checkNo.checked = false;
        }
    });

    nonTax2checkYes.addEventListener('change', function () {
        if (this.checked) {
            btnAddChildren.style.display = 'block'; 
        }
    });
   
});