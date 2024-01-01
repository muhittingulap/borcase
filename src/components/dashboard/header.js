import Link from 'next/link'

export default function Header() {
  return (
    <nav  className="sidebar js-sidebar">
      <div className="sidebar-content">
        <Link className="sidebar-brand" href="/dashboard/home">
          BorHolding
        </Link>
        <ul className="sidebar-nav">

          <li className="sidebar-item">
            <Link className="sidebar-link" href="/dashboard/home"> 
            Dashboard
            </Link>
          </li>

          <li className="sidebar-item">
            <Link className="sidebar-link" href="/dashboard/employees">
             Personel Listesi
            </Link>
          </li>

          <li className="sidebar-item">
            <Link className="sidebar-link" href="/dashboard/vehicles">
              Araç Listesi
            </Link>
          </li>

        </ul>
      </div>
    </nav>
  )
}
