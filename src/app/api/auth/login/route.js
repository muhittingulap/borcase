import { NextResponse } from 'next/server';
import { cookies } from 'next/headers'

const MAX_AGE = 60 * 60 * 24 * 30; // days;

export async function POST(req) {
  const body = await req.json();
  const token =body.token;

  const options = {
    httpOnly: true,
    secure: process.env.NODE_ENV === "production",
    sameSite: "strict",
    maxAge: MAX_AGE,
    path: "/",
  };
  cookies().set('token', token, options);

  return NextResponse.json({
    status: 200,
    message: "Authenticated!",
  });

}