<?php
namespace View;
use Model\Medicine;
use Model\Patient;
use Model\User;
use Repository\MedicineRepository;
use Repository\PatientRepository;
use Repository\UserRepository;
use View\ViewInterface;
use Repository\BD;

class PatientEditView implements ViewInterface{

    private BD $bd;
    private int $id;
    public function __construct(BD $bd,int $id)
    {
        $this->bd = $bd;
        $this->id = $id;
    }

    public function render(): void
    {
        $rep = new PatientRepository($this->bd);
        $userRep = new UserRepository($this->bd);
        $users = $userRep->findAll();
        $data = $rep->findById($this->id);
        $medicineRep = new MedicineRepository($this->bd);
        $addedMedicines = $rep->getAllMedicines($data->getId());
        $medicines = $medicineRep->findAll();

        ?>
        <form action="/db_app/save/patient">
            <input type="hidden" name="id" value="<?=$data->getId()?>">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark border-dark outline-dark text-white" id="basic-addon1">Фамилия</span>
                </div>
                <input required type="text" name="second_name" value="<?=$data->getSecondName()?>" class="border-dark form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark border-dark outline-dark text-white" id="basic-addon1">Имя</span>
                </div>
                <input required type="text" name="first_name" value="<?=$data->getFirstName()?>" class="border-dark form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark border-dark outline-dark text-white" id="basic-addon1">Отчество</span>
                </div>
                <input required type="text" name="patronymic" value="<?=$data->getPatronymic()?>" class="border-dark form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark border-dark outline-dark text-white" id="basic-addon1">Телефон</span>
                </div>
                <input required type="text" name="phone" value="<?=$data->getPhone()?>" class="border-dark form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark border-dark outline-dark text-white" id="basic-addon1">Паспорт</span>
                </div>
                <input required type="text" name="passport" value="<?=$data->getPassport()?>" class="border-dark form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark border-dark outline-dark text-white" id="basic-addon1">Домашний адрес</span>
                </div>
                <input required type="text" name="home_address" value="<?=$data->getHomeAddress()?>" class="border-dark form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark border-dark outline-dark text-white" id="basic-addon1">Номер полиса</span>
                </div>
                <input required type="text" name="policy_number" value="<?=$data->getPolicyNumber()?>" class="border-dark form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-dark border-dark outline-dark text-white" id="basic-addon1">Дата рождения</span>
                </div>
                <input required type="text" name="date_of_birth" value="<?=$data->getDateOfBirth()->format("Y-m-d")?>" class="border-dark form-control" placeholder="" aria-label="" aria-describedby="basic-addon1">
            </div>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text bg-dark text-white border-dark" for="inputGroupSelect02">Пользователь</label>
                </div>
                <select class="border-dark custom-select" id="inputGroupSelect02" name="user_id">
                    <?php
                    /* @var $item User */
                    foreach ($users as $item){
                        if($item->getId() == $data->getUserId()){
                            echo '<option selected value="'.$item->getId() .'">'.$item->getLogin().'</option>';
                        }else{
                            echo '<option value="'.$item->getId().'">'.$item->getLogin().'</option>';
                        }

                    }?>
                </select>
            </div>
            <div class="medicines_wrap">
                <?php
                /* @var $item Medicine */
                foreach($addedMedicines as $i=>$addedMedicine){
                    ?>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">

                            <label class="input-group-text bg-dark text-white border-dark" for="inputGroupSelect02">Лекарство</label>
                            <button class="btn btn-danger remove_medicine" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>
                                </svg></button>
                        </div>
                        <select class="custom-select medicineSelect border-dark" name="medicine_id[]">
                            <?php
                            /* @var $item Medicine */
                            foreach ($medicines as $item){
                                if($item->getId() == $addedMedicine->getId()){
                                    echo '<option selected value="'.$item->getId() .'">'.$item->getName().'</option>';
                                }else{
                                    echo '<option value="'.$item->getId().'">'.$item->getName().'</option>';
                                }

                            }?>
                        </select>
                    </div>
                <?php } ?>
            </div>
            <a href="#" class="btn btn-info " id="add_medicine">Добавить лекарство</a><br><br>

            <a href="/db_app/story?id=<?=$data->getId()?>" class="btn btn-primary " id="add_medicine">Просмотреть историю болезни</a><br><br>

            <button type="submit" class="btn btn-success">Сохранить</button><br><br>
        </form>
        <script>
            $(function(){
                $("#add_medicine").click(function(e){
                    e.preventDefault();
                    $(".medicines_wrap").append(
                        '<div class="input-group mb-3"><div class="input-group-prepend">'+
                        '<label class="input-group-text bg-dark text-white border-dark" >Лекарство</label>'+
                        '<button class="btn btn-danger remove_medicine" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">'+
                        '<path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8z"/>'+
                        '</svg></button></div>'+
                        '<select class="border-dark custom-select medicineSelect" name="medicine_id[]">' +
                        $("#medicinesOptions").html()+
                        '</select></div>'
                    );
                    $(".remove_medicine").click(function(e){
                        e.preventDefault();
                        $(this).parent().parent().remove();
                    })
                })

                $(".remove_medicine").click(function(e){
                    e.preventDefault();
                    $(this).parent().parent().remove();
                })


            })
        </script>

        <div id="medicinesOptions" style="display: none">
            <?php
            /* @var $item Medicine */
            foreach ($medicines as $item){
                echo '<option value="'.$item->getId().'">'.$item->getName().'</option>';
            }?>
        </div>
        <?php
    }
}
?>


