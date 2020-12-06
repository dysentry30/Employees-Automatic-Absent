</div>
</body>
<!-- Compiled and minified JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
    window.addEventListener("DOMContentLoaded", () => {
        const datepicker = document.querySelectorAll('.datepicker');
        let datepicker_options = {
            autoClose: true,
            format: "dd mmmm yyyy",
            yearRange: 60
        }
        var datepicker_instances = M.Datepicker.init(datepicker, datepicker_options);

        let select_options = {
            classes: "position"
        }
        const select = document.querySelectorAll('select');
        var select_instances = M.FormSelect.init(select, select_options);

        const checkbox_see = document.querySelector("#see");
        const password_input = document.querySelector("#password")

        let tooltip_options = {
            position: "right",
            exitDelay: 0
        }
        const tooltips = document.querySelector('.tooltipped');
        const tooltips_instances = M.Tooltip.init(tooltips, tooltip_options);

        let modal_options = {
            preventScrolling: true,
            startingTop: "100%",
            inDuration: 500,
            outDuration: 500
        }
        const modal = document.querySelectorAll('.modal');
        const modal_instances = M.Modal.init(modal, modal_options);

        // let tabs_options = {
        //     swipeable: true
        // }
        const tabs = document.querySelector(".tabs");
        const tabs_instances = M.Tabs.init(tabs)

        checkbox_see.addEventListener("change", e => {
            if (e.target.checked) {
                password_input.setAttribute("type", "text")
            } else {
                password_input.setAttribute("type", "password")
            }
        })
    })
</script>

</html>