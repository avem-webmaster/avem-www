@extends('main.home')

@push('scripts')
	<script>
		var ticketSubmitButton, ticketCodeInput;

		function onChunkKeyDown(inputElement, event) {
			switch (event.key) {
			case 'ArrowLeft':
				focusPrevInputChunk(inputElement);
				break;
			case 'ArrowRight':
				focusNextInputChunk(inputElement);
				break;
			case 'Backspace':
				if (inputElement.value == "")
					focusPrevInputChunk(inputElement);
				break;
			}
		}

		function focusPrevInputChunk(inputElement) {
			if (inputElement.previousElementSibling)
				inputElement.previousElementSibling.focus();
		}

		function focusNextInputChunk(inputElement) {
			if (inputElement.nextElementSibling)
				inputElement.nextElementSibling.focus();
			else
				ticketSubmitButton.focus();
		}

		function onChunkInput(inputElement) {
			if (inputElement.value !== "")
				focusNextInputChunk(inputElement);
		}

		function onTicketFormSubmit(formElement, event) {
			event.preventDefault();
			var ticketChunkElements = formElement.querySelectorAll('input.input-chunk');
			var ticketChunks = Array.from(ticketChunkElements).map(chunk => chunk.value);
			ticketCodeInput.value = ticketChunks.join('').toLowerCase();
			formElement.submit();
		}

		$(function() {
			ticketCodeInput = $('#input-code')[0];
			ticketSubmitButton = $('#input-submit');
		});
	</script>
@endpush

@section('home-content')
	<section class="card p-3">
		<h3>Canjear ticket</h3>

		<div class="my-2">
			@if (Session::has('exchange-error'))
				<div class="alert alert-warning">
					{!! Session::get('exchange-error') !!}
				</div>
			@endif

			@if (Session::has('exchange-success'))
				<div class="alert alert-success">
					{!! Session::get('exchange-success') !!}
				</div>
			@endif

			@if ($user->isActive)
				<div class="row">
					<div class="col-lg-8 offset-lg-2">
						<form action="{{ route('ticket.exchange') }}"
						      method="post" onsubmit="onTicketFormSubmit(this, event)">
							{{ csrf_field() }}

							<div class="form-group">
								<label for="input-code-first" class="mb-2">
									Introduzca el código que aparece en su ticket:
								</label>

								<input id="input-code" type="hidden" name="code">

								<ul class="input-chunks">
									<input id="input-code-first" maxlength="1"
									       class="input-chunk input-chunk--upcase"
									       onkeydown="onChunkKeyDown(this, event)"
									       oninput="onChunkInput(this)">
									@for ($i = 1; $i < 8; ++$i)
										<input type="text" maxlength="1"
										       class="input-chunk input-chunk--upcase"
										       onkeydown="onChunkKeyDown(this, event)"
										       oninput="onChunkInput(this)">
									@endfor
								</ul>
							</div>

							<div class="mt-2">
								<button id="input-submit" type="submit" role="button" class="btn btn-primary">
									Canjear
								</button>
							</div>
						</form>
					</div>
				</div>
			@else
				<p class="text-center">
					<i class="mr-2 fa fa-lg fa-warning"></i>
					Lo sentimos, pero es necesario estar activado para poder canjear
					un ticket. Pásate por el despacho o envía un correo a
					<a href="mailto:tesoreria@avem.es">tesoreria@avem.es</a>.
				</p>
			@endif
		</div>
	</section>
@stop
