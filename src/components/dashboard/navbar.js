
export default function NavBar() {
  return (
    <nav className="navbar navbar-expand navbar-light navbar-bg">

      <div className="navbar-collapse collapse">
        <ul className="navbar-nav navbar-align">
          <li className="nav-item dropdown">
            <button className="nav-link dropdown-toggle d-none d-sm-inline-block"
              data-bs-toggle="dropdown">
              <span className="text-dark">Kullanıcı adı</span>
            </button>
            <div className="dropdown-menu dropdown-menu-end">
              <button className="dropdown-item" >Çıkış Yap</button>
            </div>
          </li>
        </ul>
      </div>
    </nav>
  )
}
