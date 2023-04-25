let paso=1;const pasoInicial=1,pasoFinal=3,cita={id:"",nombre:"",fecha:"",hora:"",servicios:[]},botonAnterior=document.querySelector("#anterior"),botonSiguiente=document.querySelector("#siguiente");function iniciarApp(){mostrarSeccion(),tabs(),botonesPaginador(),btnSiguiente(),btnAnterior(),consultarAPI(),idCliente(),nombreCliente(),fechaMinima(),seleccionarFecha(),seleccionarHora(),mostrarResumen()}function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",e=>{paso=parseInt(e.target.dataset.paso),mostrarSeccion(),botonesPaginador()})})}function mostrarSeccion(){const e=document.querySelector("#paso-"+paso),t=document.querySelector(".mostrar");t&&t.classList.remove("mostrar"),e.classList.add("mostrar");const o=document.querySelector(`[data-paso="${paso}"]`),n=document.querySelector(".actual");n&&n.classList.remove("actual"),o.classList.add("actual")}function botonesPaginador(){1===paso?(botonAnterior.classList.add("ocultar"),botonSiguiente.classList.remove("ocultar")):3===paso?(botonAnterior.classList.remove("ocultar"),botonSiguiente.classList.add("ocultar"),mostrarResumen()):(botonAnterior.classList.remove("ocultar"),botonSiguiente.classList.remove("ocultar")),mostrarSeccion()}function btnAnterior(){botonAnterior.addEventListener("click",()=>{paso<=1||(paso--,botonesPaginador())})}function btnSiguiente(){botonSiguiente.addEventListener("click",()=>{paso>=3||(paso++,botonesPaginador())})}async function consultarAPI(){try{const e="http://localhost:3000/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){const t=document.querySelector("#servicios");e.forEach(e=>{const{id:o,nombre:n,precio:a}=e,c=document.createElement("P");c.classList.add("nombre-servicio"),c.textContent=n;const r=document.createElement("P");r.classList.add("precio-servicio"),r.textContent="$"+a;const i=document.createElement("DIV");i.classList.add("servicio"),i.dataset.idservicio=o,i.onclick=()=>{seleccionarServicio(e)},i.appendChild(c),i.appendChild(r),t.appendChild(i)})}function seleccionarServicio(e){const{id:t}=e,o=document.querySelector(`[data-idservicio="${t}"]`),{servicios:n}=cita;n.some(e=>e.id===t)?(cita.servicios=n.filter(e=>e.id!==t),o.classList.remove("seleccionado")):(cita.servicios=[...n,e],o.classList.add("seleccionado"))}function idCliente(){const e=document.querySelector("#id").value;cita.id=e}function nombreCliente(){const e=document.querySelector("#nombre").value;cita.nombre=e}function fechaMinima(){document.querySelector("#fecha").setAttribute("min",obtenerFechaActual(1))}function obtenerFechaActual(e=0){const t=new Date;return t.setDate(t.getDate()+e),t.toISOString().split("T")[0]}function seleccionarFecha(){const e=document.querySelector("#fecha");e.addEventListener("input",t=>{const o=t.target.value,n=new Date(o).getUTCDay();[6,0].includes(n)?(e.value="",mostrarAlerta("Sabados y Domingos no abrimos","error","paso-2 p")):cita.fecha=o})}function seleccionarHora(){document.querySelector("#hora").addEventListener("input",e=>{const t=e.target.value,o=t.split(":")[0];o<10||o>18?(e.target.value="",mostrarAlerta("Atención de 10:00 a 18:00.","error","paso-2 p")):cita.hora=t})}function mostrarAlerta(e,t,o,n=!0){const a=document.querySelector(".alerta");a&&a.remove();const c=document.createElement("P");c.textContent=e,c.classList.add("alerta",t);document.querySelector("#"+o).appendChild(c),n&&setTimeout(()=>{c.remove()},5e3)}function mostrarResumen(){const e=document.querySelector("#contenidoResumen");for(;e.firstChild;)e.removeChild(e.firstChild);const t=Object.values(cita).includes(""),o=0===cita.servicios.length;if(t||o)return void mostrarAlerta("Hace falta información o agregar algún servicio","error","contenidoResumen",!1);const{nombre:n,fecha:a,hora:c,servicios:r}=cita,i=document.createElement("H3");i.classList.add("heading-resumen"),i.textContent="Servicios Solicitados",e.appendChild(i),r.forEach(t=>{const{id:o,nombre:n,precio:a}=t,c=document.createElement("DIV");c.classList.add("contenedor-servicio");const r=document.createElement("P");r.textContent=n;const i=document.createElement("P");i.textContent="Precio: ",i.classList.add("texto-span");const s=document.createElement("SPAN");s.textContent="$"+a,i.appendChild(s),c.appendChild(r),c.appendChild(i),e.appendChild(c)});const s=document.createElement("H3");s.classList.add("heading-resumen"),s.textContent="Información de la Cita",e.appendChild(s);const d=document.createElement("P");d.textContent="Nombre: ",d.classList.add("texto-span");const l=document.createElement("SPAN");l.textContent=n,d.appendChild(l);const u=new Date(a),m=u.getMonth(),p=u.getDate()+2,h=u.getFullYear(),C=new Date(Date.UTC(h,m,p)).toLocaleDateString("es-MX",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),v=document.createElement("P");v.textContent="Fecha: ",v.classList.add("texto-span");const S=document.createElement("SPAN");S.textContent=C,v.appendChild(S);const b=document.createElement("P");b.textContent="Hora: ",b.classList.add("texto-span");const f=document.createElement("SPAN");f.textContent=c+" horas",b.appendChild(f);const g=r.reduce((e,t)=>e+parseFloat(t.precio),0),L=document.createElement("P");L.textContent="Total a pagar: ",L.classList.add("texto-span","texto-total");const E=document.createElement("SPAN");E.classList.add("span-total"),E.textContent=`$${g}.00`,L.appendChild(E),e.appendChild(d),e.appendChild(v),e.appendChild(b),e.appendChild(L);const y=document.createElement("BUTTON");y.classList.add("boton"),y.textContent="Reservar Cita",y.onclick=reservarCita,e.appendChild(y)}async function reservarCita(){const{id:e,fecha:t,hora:o,servicios:n}=cita,a=n.map(e=>e.id),c=new FormData;c.append("fecha",t),c.append("hora",o),c.append("usuarioId",e),c.append("servicios",a);try{const e="http://localhost:3000/api/citas",t={method:"POST",body:c},o=await fetch(e,t);(await o.json()).resultado&&Swal.fire({icon:"success",title:"Cita creada correctamente",text:"Muchas gracias por reservar con nosotros :)"}).then(()=>{window.location.reload()})}catch(e){Swal.fire({icon:"error",title:"Error",text:"Hubo un error al guardar la cita"})}}document.addEventListener("DOMContentLoaded",()=>{iniciarApp()});