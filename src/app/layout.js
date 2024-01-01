import { Inter } from 'next/font/google'
import './globals.css'

const inter = Inter({ subsets: ['latin'] })

export const metadata = {
  title: 'BorHolding',
  description: 'Araç zimmet takip uygulaması',
}

export default function RootLayout({ children }) {
  return (
    <html lang="en">
      <body>
        {children}
      
        <script src="/assets/js/app.js"></script>
      </body>
    </html>
  )
}
