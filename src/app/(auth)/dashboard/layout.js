import { Inter } from 'next/font/google'
import './../../globals.css'
import NavBar from '@/components/dashboard/navbar'
import Header from '@/components/dashboard/header'
import Footer from '@/components/dashboard/footer'
const inter = Inter({ subsets: ['latin'] })

export const metadata = {
  title: 'BorHolding',
  description: 'Araç zimmet takip uygulaması paneli',
}

export default function DasboardLayout({ children }) {
  
  return (
    <div className="wrapper">
      <Header />

      <div className="main">
        <NavBar />

        <main className="content">

            {children}

        </main>

        <Footer />

      </div>
    </div>
  )
}