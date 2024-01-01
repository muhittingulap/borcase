"use client";

import { useState } from "react";
import { useForm } from "react-hook-form";
import axios from "@/libs/axios";
import { useRouter } from 'next/navigation'
import Swal from 'sweetalert2'

export default function page() {
	const router = useRouter();
	const [isLoading, setLoading] = useState(false);
	const { register, handleSubmit, formState: { errors } } = useForm();
	/* form action */
	const submitLogin = async (data) => {
		setLoading(true);

		await axios.get('/sanctum/csrf-cookie');
		await axios.post('/v1/login', data).then(
			async (response) => {
				setLoading(false);
				if (response?.data?.status) {

					const res = await fetch('/api/auth/login', {
						method: 'POST',
						headers: {
							'Accept': 'application/json',
							'Content-Type': 'application/json'
						},
						body: JSON.stringify({ token: response?.data?.data?.auth?.token })
					});

					if (res?.status == 200) router.push('/dashboard/home');
				}
			}
		);
	}

	return (

		<main className="d-flex w-100">
			<div className="container d-flex flex-column">
				<div className="row vh-100">
					<div className="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
						<div className="d-table-cell align-middle">

							<div className="text-center mt-4">
								<h1 className="h2">Hoş Geldiniz !</h1>
								<p className="lead">
									Giriş yapmak için hesap bilgilerinizi giriniz.
								</p>
							</div>

							<div className="card">
								<div className="card-body">
									<div className="m-sm-3">
										<form onSubmit={handleSubmit(submitLogin)}>
											<div className="mb-3">
												<label className="form-label">Email</label>
												<input className="form-control form-control-lg" type="email" name="email" placeholder="Email giriniz"   {...register("email", { required: true, pattern: /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/ })} />
												{errors.email && errors.email?.type === 'required' && <span className='invalid-text' style={{ color: 'red' }}>Lütfen email adresinizi giriniz !</span>}
												{errors.email && errors.email?.type === 'pattern' && <span className='invalid-text' style={{ color: 'red' }}>Gerçerli bir email adresi girmelisiniz</span>}
											</div>
											<div className="mb-3">
												<label className="form-label">Şifre</label>
												<input className="form-control form-control-lg" type="password" name="password" placeholder="Şifre giriniz" {...register("password", { required: true })} />
												{errors.password && errors.password?.type === 'required' && <span className='invalid-text' style={{ color: 'red' }}>Lütfen şifrenizi giriniz !</span>}
											</div>
											<div className="d-grid gap-2 mt-3">
												<button className="btn btn-lg btn-primary">Giriş Yap</button>
											</div>
										</form>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</main>
	)
}