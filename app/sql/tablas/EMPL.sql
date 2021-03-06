/*Maestro de Empleadores*/
IF OBJECT_ID('EMPL','U') IS NOT NULL DROP TABLE EMPL
GO
CREATE TABLE dbo.EMPL(
	TipoID VARCHAR(2) NOT NULL,
	NumeroIdentificacion VARCHAR(16) NOT NULL,
	RazonSocial VARCHAR(500) NOT NULL,
	DireccionFiscal VARCHAR(500) NOT NULL,
	Email VARCHAR(150) NOT NULL,
	Telefono VARCHAR(10) NOT NULL,
    MunicipioID VARCHAR(10) NOT NULL,
    UsuarioID VARCHAR(100) NOT NULL,
    SedeID VARCHAR(100) NOT NULL,
    NaturalezaID VARCHAR(2) NOT NULL,
    RegimeEmpresaID VARCHAR(2) NOT NULL,
    TamanoID VARCHAR(2) NOT NULL,
    TipoEmpresaID VARCHAR(2) NOT NULL,
	FechaRegistro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) 
GO
ALTER TABLE dbo.EMPL ADD CONSTRAINT EMPLTIPOIDNUMEROIDENTIFICACION PRIMARY KEY CLUSTERED (TipoID ASC, NumeroIdentificacion ASC)
GO
ALTER TABLE dbo.EMPL ADD CONSTRAINT EMPLUSUUSUARIOIDSEDEID FOREIGN KEY (USUARIOID,SEDEID) REFERENCES USU (USUARIOID, SEDEID)
GO
ALTER TABLE dbo.EMPL ADD CONSTRAINT EMPLTIDTIPOID FOREIGN KEY (TipoID) REFERENCES TID(TipoId)
GO
ALTER TABLE dbo.EMPL ADD CONSTRAINT EMPLMUNMUNICIPIOID FOREIGN KEY (MunicipioID) REFERENCES MUN(MunicipioID)
GO
ALTER TABLE dbo.EMPL ADD CONSTRAINT EMPLNATNATURALEZAID FOREIGN KEY (NaturalezaID) REFERENCES NAE(NaturalezaID)
GO
ALTER TABLE dbo.EMPL ADD CONSTRAINT EMPLREMREGIMEEMPRESAID FOREIGN KEY (RegimeEmpresaID) REFERENCES REM(RegimeEmpresaID)
GO
ALTER TABLE dbo.EMPL ADD CONSTRAINT EMPLTAETAMANOID FOREIGN KEY (TamanoID) REFERENCES TAE(TamanoID)
GO
ALTER TABLE dbo.EMPL ADD CONSTRAINT EMPLTEMTipoEmpresaID FOREIGN KEY (TipoEmpresaID) REFERENCES TEM(TipoEmpresaID)
GO