<style>
    body {
        overflow-y: visible !important;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col">
            <h4><b>Setting Time to Work and Home</b></h4>
        </div>
    </div>

    <form action="<?= base_url("setting-time"); ?>" method="POST">
        <div class="row">
            <div class="col s6">
                <div class="input-field">
                    <select name="hours-work" id="hours-work">
                        <option value="null" selected disabled>In hours</option>
                        <option value="7">07:00 AM</option>
                        <option value="8">08:00 AM</option>
                        <option value="9">09:00 AM</option>
                        <option value="10">10:00 AM</option>
                        <option value="11">11:00 AM</option>
                        <option value="12">12:00 AM</option>
                        <option value="13">13:00 PM</option>
                        <option value="14">14:00 PM</option>
                        <option value="15">15:00 PM</option>
                        <option value="16">16:00 PM</option>
                        <option value="17">17:00 PM</option>
                        <option value="18">18:00 PM</option>
                        <option value="19">19:00 PM</option>
                        <option value="20">20:00 PM</option>
                        <option value="21">21:00 PM</option>
                        <option value="22">22:00 PM</option>
                        <option value="23">23:00 PM</option>
                    </select>
                    <label for="hours-work">Time to work</label>
                </div>
            </div>
            <div class="row">
                <div class="col s6">
                    <div class="input-field">
                        <select name="hours-home" id="hours-home">
                            <option value="null" selected disabled>In hours</option>
                            <option value="7">07:00 AM</option>
                            <option value="8">08:00 AM</option>
                            <option value="9">09:00 AM</option>
                            <option value="10">10:00 AM</option>
                            <option value="11">11:00 AM</option>
                            <option value="12">12:00 AM</option>
                            <option value="13">13:00 PM</option>
                            <option value="14">14:00 PM</option>
                            <option value="15">15:00 PM</option>
                            <option value="16">16:00 PM</option>
                            <option value="17">17:00 PM</option>
                            <option value="18">18:00 PM</option>
                            <option value="19">19:00 PM</option>
                            <option value="20">20:00 PM</option>
                            <option value="21">21:00 PM</option>
                            <option value="22">22:00 PM</option>
                            <option value="23">23:00 PM</option>
                        </select>
                        <label for="hours-work">Time to go home</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <button type="submit" class="btn green darken-2" name="submit">Set Time</button>
            </div>
        </div>
    </form>
</div>