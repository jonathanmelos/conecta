<div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Plan Mensual</span>
           </h4>
        <ul class="list-group mb-3">
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h3 class="my-0"><?php echo $plan; ?></h6>
              <small class="text-body-secondary">Vencimiento mensual el: <br>
				  <?php echo $fechaprox; ?></small>
            </div>
            
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Horas en COWORK</h6>
            
            
            <span class="text-body-secondary">
				Contratadas: <?php echo $cowork;?>:00 
				<br>Usadas:  <?php echo $tiempoCowork ?>
			  	<br>Restantes: <?php echo $tiempo_restante_HHMM ?> 
			  </span>
			</div>	
          </li>
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Horas en Sala Reuniones</h6>
              <span class="text-body-secondary">
				  Contratadas: <?php echo $sala; ?>:00</span>
				<br>Usadas:  <?php echo $tiempoSala ?>
			  	<br>Restantes: <?php echo $tiempo_restante_HHMMS ?>
            </div>
            
          </li>
            <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Cantidad Impresiones</h6>
                         
            <span class="text-body-secondary">
				Contratadas: <?php echo $impresiones ?></span>
				<br>Usadas:  <?php echo $totalImpresiones?>
			  	<br>Restantes: <?php echo $ImpresionesDif  ?>
			</div>	
				</span>
          </li>
		<li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">Eventos Connecta</h6>
              
            </div>
            <span class="text-body-secondary"><?php echo $evento; ?></span>
          </li>	
          <li class="list-group-item d-flex justify-content-between">
            <span>Precio</span>
            <strong><?php echo $precio ?></strong>
          </li>
        </ul>

       
    </div>
	 	

	 
  </div>
	
		
